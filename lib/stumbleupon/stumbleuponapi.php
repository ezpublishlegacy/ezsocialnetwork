<?php
/**
 * 
 * @licence http://www.gnu.org/licenses/gpl-2.0.txt GNU GPLv2
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */

class StumbleUponAPI extends SocialRequest
{
    const VERSION = '1.01';
    const HOST = 'http://www.stumbleupon.com/';
    const TIMEOUT = 2;

    private function __construct() {
        $this->configCurl = array(
            CURLOPT_FAILONERROR => true,
            CURLOPT_TIMEOUT => self::TIMEOUT
        );
    }

    /**
     * build the url
     * @param  [type] $method [description]
     * @return [type]         [description]
     */
    public function url($method) {
        return StumbleUponAPI::HOST.$method;
    }

    /**
     * The Badge API allows web site publishers to create custom StumbleUpon badges
     * on their web pages by querying information about the page which the badge 
     * sits on. This is provided through a simple REST API with output in JSON
     * format.
     * 
     * @param  string $url [description]
     * @return [type]      [description]
     */
    public static function countByUrl($parameters) {
        $instanceStumbleUpon = new StumbleUponAPI();
        /**
         * This instance return an object JSON
         * @var result
         * result           object      The resulting data from the API call.
         *      url         string      The URL you sent us. This may be a canonicalized URL,
         *                              but should point to the same content. A canonical URL
         *                              in our system is one without tracking codes, anchor #’s, 
         *                              etc.
         *      in_index    literal     If the URL you sent has been submitted to us by our users,
         *                              this will return true. Otherwise, we will return false.
         *      publicid    string      This is the identifier to this URL in our index. This 
         *                              value is unused for now, but will very likely be used in
         *                              the future.
         *      views       number      The number of times this URL has been stumbled upon by our users.
         *      title       string      The title of the page as deduced from the <title>tag of the URL.
         *      thumbnail   string      The URL to the regular sized thumbnail image (129 x 86 pixels).
         *      thumbnail_b string      The URL to the big thumbnail image (283 x 184 pixels).
         *      submit_link string      The URL to navigate users to who want to submit the URL to
         *                              us if new, and rate the URL if existing. This is a page designed
         *                              to layout in a full page, not a pop-up.
         *      badge_link  string      The URL to navigate userse to who want to submit or rate the URL.
         *                              This is a page designed to layout in a pop-up with height and
         *                              width ratio of 5 to 4 (so 450 x 360 pixels would be an appropriate
         *                              size). The actual pixel size will depend on the end-user’s graphics
         *                              capabilities and default font size.
         *      info_link   string      The URL to display an informational page about a URL in our index.
         * timestamp        number      Date/time when the response was served (in Unix time format).
         * success          literal     true if no error was encountered in fetching and returning a
         *                              response. false otherwise (see below for possible error codes).
         */
        $jsonString = $instanceStumbleUpon->request($instanceStumbleUpon->url("services/1.01/badge.getinfo"), $parameters);
        $json = json_decode($jsonString, true);
        /**
         * 9000     Service temporarily unavailable
         * 9020     Bad or missing parameter: url
         * 9030     Rate-limit exceeded
         * 9031     Rate-limit exceeded
         */
        if (isset($json['error_code'])) {
            eZDebug::writeError( $json['error_message'] . ": ". $json['error_message'], 'StumbleUpon API' );
            return false;
        }
        return isset($json['result']['views'])?intval($json['result']['views']):0;
    }
}

