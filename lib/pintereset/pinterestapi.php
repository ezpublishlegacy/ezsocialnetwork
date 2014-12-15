<?php
/**
 * Pintereset : immense pense-bete (photos, contenus, do it yourself)
 * @licence http://www.gnu.org/licenses/gpl-2.0.txt GNU GPLv2
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */

class PinterestAPI extends SocialRequest
{
    const VERSION = 1;
    const HOST = 'http://api.pinterest.com/';
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
        return PinterestAPI::HOST.$method;
    }

    /**
     * Check back here for future changes.
     * @param  string $url [description]
     * @return [type]      [description]
     */
    public static function statsUrl($parameters) {
        $instancePinterest = new PinterestAPI();
        /**
         * This instance return an object JSON
         * @var count
         */
        $jsonString = $instancePinterest->request($instancePinterest->url("v1/urls/count.json"), $parameters);
        $jsonString = preg_replace("/^receiveCount\((.*)\)$/", "$1", $jsonString);
        $json       = json_decode($jsonString, true);
        if (isset($json['error'])) {
            eZDebug::writeError( $json['error'], 'Pinterest API' );
            return false;
        }
        return isset($json['count'])?intval($json['count']):0;
    }
}

