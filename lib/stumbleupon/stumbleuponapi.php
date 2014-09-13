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
    public static function countByUrl($parameters) {
        $instanceStumbleUpon = new StumbleUponAPI();
        /**
         * This instance return an object JSON
         * @var count
         * @var fCnt
         * @var fCntPlusOne
         * @var url
         */
        $jsonString = $instanceStumbleUpon->request($instanceStumbleUpon->url("services/1.01/badge.getinfo"), $parameters);
        $json = json_decode($jsonString, true);
        if (isset($json['error_code'])) {
            eZDebug::writeError( $json['error_message'] . ": ". $json['error_message'], 'StumbleUpon API' );
            return false;
        }
        return isset($json['result']['views'])?intval($json['result']['views']):0;
    }
}

