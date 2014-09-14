<?php
/**
 * 
 * @licence http://www.gnu.org/licenses/gpl-2.0.txt GNU GPLv2
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */

class LinkedinAPI extends SocialRequest
{
    const HOST = 'http://www.linkedin.com/';
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
        return LinkedinAPI::HOST.$method;
    }

    /**
     * If, for security reasons, you can not load the LinkedIn JavaScript framework 
     * you can make a direct request to the share count endpoint to retrieve the count.
     * Using the endpoint is as simple as sending the URL of interest and receiving 
     * back a small piece of JSON for you to process.
     * This endpoint is intended primarily for LinkedIn internal use and as such there 
     * is no guarantee about the stability of the URL or the permanence of its signature.
     * 
     * Check back here for future changes.
     * @param  string $url [description]
     * @return [type]      [description]
     */
    public static function statsUrl($parameters) {
        $instanceLinkeding = new LinkedinAPI();
        /**
         * This instance return an object JSON
         * @var count
         * @var fCnt
         * @var fCntPlusOne
         * @var url
         */
        $jsonString = $instanceLinkeding->request($instanceLinkeding->url("countserv/count/share"), $parameters);
        $json = json_decode($jsonString, true);
        return isset($json['count'])?$json:0;
    }
}

