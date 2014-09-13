<?php
/**
 * 
 * @licence http://www.gnu.org/licenses/gpl-2.0.txt GNU GPLv2
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */

class GoogleAPI extends SocialRequest
{
	const VERSION = "v1";
    const HOST = 'https://clients6.google.com/';
    const TIMEOUT = 2;

    private function __construct() {
        $this->configCurl = array(
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => array('Content-type: application/json'),
        );
    }

    /**
     * build the url
     * @param  [type] $method [description]
     * @return [type]         [description]
     */
    public function url($method) {
        return GoogleAPI::HOST.$method;
    }

    /**
     *  API will be deprecated
     * 
     * Check back here for future changes.
     * @param  string $url [description]
     * @return [type]      [description]
     */
    public static function statsByUrl($parameters) {
        $instanceGoogle = new GoogleAPI();
        /**
         * This instance return an object JSON
         * @var count
         * @var fCnt
         * @var fCntPlusOne
         * @var url
         */
        $jsonString = $instanceGoogle->request($instanceGoogle->url("rpc"), "[".json_encode($parameters)."]");
        $json = json_decode($jsonString, true);
        if (!$json) {
            eZDebug::writeError( "No Data", 'Google API' );
            return false;
        }
        return $json;
    }
}

