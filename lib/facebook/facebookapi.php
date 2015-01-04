<?php
/**
 *
 * @licence http://www.gnu.org/licenses/gpl-2.0.txt GNU GPLv2
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */

class FacebookAPI extends SocialRequest
{
    const HOST = 'http://api.facebook.com/';
    const TIMEOUT = 2;

    private function __construct()
    {
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
    public function url($method)
    {
        return FacebookAPI::HOST.$method;
    }

    /**
     *  API will be deprecated
     *
     * Check back here for future changes.
     * @param  string $url [description]
     * @return [type]      [description]
     */
    public static function statsUrl($parameters)
    {
        $instanceFacebook = new FacebookAPI();
        $parameters['method'] = 'links.getStats';
        /**
         * This instance return an object JSON
         * @var count
         * @var fCnt
         * @var fCntPlusOne
         * @var url
         */
        $jsonString = $instanceFacebook->request($instanceFacebook->url("restserver.php"), $parameters);
        $json = json_decode($jsonString, true);
        if (isset($json['error_code'])) {
            eZDebug::writeError($json['error_msg'] . ": ". $json['error_msg'], 'Facebook API');
            return false;
        }
        return $json;
    }
}
