<?php
/**
 * 
 * @licence http://www.gnu.org/licenses/gpl-2.0.txt GNU GPLv2
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */

class GooglePlusAPI extends SocialRequest
{
    const VERSION = "v1";
    const HOST = 'https://clients6.google.com/';
    const TIMEOUT = 2;

    private function __construct()
    {
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
    public function url($method)
    {
        return GooglePlusAPI::HOST.$method;
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
        $instanceGoogle = new GooglePlusAPI();
        $request = array(
            'method' => 'pos.plusones.get',
            'id' => 'p',
            'params' => array(
                "nolog"   => true,
                "id"      => rawurldecode($parameters['url']),
                "source"  => "widget",
                "userId"  => "@viewer",
                "groupId" => "@self"
            ),
            "jsonrpc"    => "2.0",
            "key"        => "p",
            "apiVersion" => "v1"
        );
        /**
         * This instance return an object JSON
         * @var count
         * @var fCnt
         * @var fCntPlusOne
         * @var url
         */
        $jsonString = $instanceGoogle->request($instanceGoogle->url("rpc"), "[".json_encode($request)."]");
        $json = json_decode($jsonString, true);
        if (!$json) {
            eZDebug::writeError("No Data", 'Google API');
            return false;
        }
        return $json;
    }
}
