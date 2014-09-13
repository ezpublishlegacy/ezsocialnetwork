<?php
/**
 * @licence http://www.gnu.org/licenses/gpl-2.0.txt GNU GPLv2
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */

class GooglePlus extends SocialModel
{
    public $url = "";
    public $timeout = 5;
    public $json = 'json';

    /**
     * [countSharesTweetByUrl description]
     * @return [type] [description]
     * @api
     */
    public function countByUrl()
    {
        return GoogleAPI::statsByUrl(array(
            'method' => 'pos.plusones.get',
            'id' => 'p',
            'params' => array(
                "nolog"   => true,
                "id"      => rawurldecode($this->url),
                "source"  => "widget",
                "userId"  => "@viewer",
                "groupId" => "@self"
            ),
            "jsonrpc"    => "2.0",
            "key"        => "p",
            "apiVersion" => "v1"
        ));
    }

    /**
     * [shared description]
     * @param  [type] $url [description]
     * @return [type]      [description]
     */
    public static function shared($urls)
    {
        if (!empty($urls) && is_string($urls)) {
            $facebook = new GooglePlus(array(
                'urls' => $urls
            ));
            $facebook->countByUrl();
        }
    }
}
