<?php
/**
 * 
 * @licence http://www.gnu.org/licenses/gpl-2.0.txt GNU GPLv2
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */

class FacebookFQL extends SocialRequest
{
    const HOST = 'https://api.facebook.com/';
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
    public function url($method) {
        return GoogleAPI::HOST.$method;
    }

    /**
     * @param  string $parameters [description]
     *                $ids => url
     * @return [type]      [description]
     */
    public static function statOneUrl($parameters) {
        $instanceFacebook = new FacebookFQL();
        $query  = " SELECT url, normalized_url, share_count, like_count,
                    comment_count, total_count, comments_fbid, click_count
                    FROM link_stat WHERE url = '".$parameters["url"]."'";
        unset($parameters["url"]);
        $parameters['query'] = urlencode($query);
        $jsonString = $instanceFacebook->request($instanceFacebook->url('method/fql.query'), $parameters);

        $json = json_decode($jsonString, true);
        if (isset($json['error_code'])) {
            eZDebug::writeError( $json['error_msg'] . ": ". $json['error_msg'], 'Facebook API' );
            return false;
        }
        return $json;
    }

    /**
     * [statMultipleUrls description]
     * @param  [type] $parameters [description]
     * @return [type]             [description]
     */
    public static function statMultipleUrls($parameters) {
        $instanceFacebook = new FacebookFQL();
        $query  = " SELECT url, normalized_url, share_count, like_count,
                    comment_count, total_count, comments_fbid, click_count
                    FROM link_stat WHERE url IN(".$parameters["url"].")";
        unset($parameters["url"]);
        $parameters['query'] = urlencode($query);
        $jsonString = $instanceFacebook->request($instanceFacebook->url('method/fql.query'), $parameters);

        $json = json_decode($jsonString, true);
        if (isset($json['error_code'])) {
            eZDebug::writeError( $json['error_msg'] . ": ". $json['error_msg'], 'Facebook API' );
            return false;
        }
        return $json;
    }
}