<?php
/**
 * 
 * @licence http://www.gnu.org/licenses/gpl-2.0.txt GNU GPLv2
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */

class FacebookGraph
{
    const HOST = 'http://graph.facebook.com/';
    const TIMEOUT = 2;

    private function __construct() {
        $this->configCurl = array(
        );
    }

    /**
     * build the url
     * @param  [type] $method [description]
     * @return [type]         [description]
     */
    public function host() {
        return FacebookGraph::HOST;
    }

    /**
     * @param  string $parameters [description]
     *                $ids => url
     * @return [type]      [description]
     */
    public static function statsUrl($parameters) {
        $instanceFacebook = new FacebookGraph();
        $jsonString = $instanceFacebook->request($instanceFacebook->host(), $parameters);
        $json = json_decode($jsonString, true);
        if (isset($json['error_code'])) {
            eZDebug::writeError( $json['error_msg'] . ": ". $json['error_msg'], 'Facebook API' );
            return false;
        }
        return $json;
    }
}