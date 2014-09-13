<?php
/**
 * @licence http://www.gnu.org/licenses/gpl-2.0.txt GNU GPLv2
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */

class Twitter extends SocialModel
{
    public $url = "";
    public $timeout = 5;

    /**
     * [countSharesTweetByUrl description]
     * @return [type] [description]
     * @api
     */
    public function countSharesTweetByUrl()
    {
        return TwitterAPI::countSharesTweetByUrl($this->url);
    }

    /**
     * [shared description]
     * @param  [type] $url [description]
     * @return [type]      [description]
     */
    public static function shared($url)
    {
        if (!empty($url) && is_string($url)) {
            $twitter = new Twitter(array(
                'url' => $url
            ));
            $twitter->countSharesTweetByUrl();
        }
    }
}
