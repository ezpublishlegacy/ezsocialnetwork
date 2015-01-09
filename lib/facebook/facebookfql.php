<?php
/**
 *
 * @licence http://www.gnu.org/licenses/gpl-2.0.txt GNU GPLv2
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */

class facebookfql extends SocialRequest
{
    const HOST = 'https://api.facebook.com/';
    const TIMEOUT = 2;

    private function __construct()
    {
        $this->configCurl = array(
        );
    }

    /**
     * build the url
     * @param  [type] $method [description]
     * @return [type]         [description]
     */
    public function url($method)
    {
        return GoogleAPI::HOST.$method;
    }

    /**
     * @param  string $parameters [description]
     *                $ids => url
     * @return [type]      [description]
     */
    public static function statsUrl($parameters)
    {
        $countUrl = 0;
        if (isset($parameters["urls"])) {
            $countUrl = substr_count($parameters["urls"], ',');
        }
        $instanceFacebook = new FacebookFQL();
        $query  = " SELECT  url,
                            normalized_url,
                            share_count,
                            like_count,
                            comment_count,
                            total_count,
                            comments_fbid,
                            click_count";
        if ($countUrl > 1) {
            $query  .= " FROM link_stat
                WHERE url IN(".$parameters["urls"].")";
        } else {
            $query  .= " FROM link_stat
                WHERE url = '".$parameters["urls"]."'";
        }
        unset($parameters["urls"]);
        $parameters['query'] = urlencode($query);
        $jsonString = $instanceFacebook->request($instanceFacebook->url('method/fql.query'), $parameters);

        $json = json_decode($jsonString, true);
        if (isset($json['error_code'])) {
            eZDebug::writeError($json['error_msg'] . ": ". $json['error_msg'], 'Facebook API');
            return false;
        }
        return $json;
    }
}
