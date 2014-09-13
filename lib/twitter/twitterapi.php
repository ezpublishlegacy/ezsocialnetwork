<?php
/**
 * 
 * @licence http://www.gnu.org/licenses/gpl-2.0.txt GNU GPLv2
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */

class TwitterAPI extends SocialRequest
{
    const VERSION = '1';
    const HOST = 'http://urls.api.twitter.com/';
    const FORMAT = 'json';
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
        return TwitterAPI::HOST.$method;
    }

    /**
     * That is an undocumented endpoint that is not permitted for use in any version of the API.
     * @param  [type] $url [description]
     * @return [type]      [description]
     */
    public static function countSharesTweetByUrl($url) {
        $instanceTwitter = new TwitterAPI();
        /**
         * This instance return an object JSON
         * @var url
         * @var count
         */
        $jsonString = $instanceTwitter->request($instanceTwitter->url("1/urls/count.json"), array('url' => $url));
        $json = json_decode($jsonString, true);
        return isset($json['count'])?intval($json['count']):0;
    }
}

