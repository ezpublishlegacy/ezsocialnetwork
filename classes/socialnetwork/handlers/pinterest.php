<?php
/**
 * @licence http://www.gnu.org/licenses/gpl-2.0.txt GNU GPLv2
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */

class Pinterest extends SocialModel
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
        return PinterestAPI::countByUrl(array(
            'url' => $this->url,
        ));
    }

    /**
     * [shared description]
     * @param  [type] $url [description]
     * @return [type]      [description]
     */
    public static function shared($url)
    {
        if (!empty($url) && is_string($url)) {
            $facebook = new Pinterest(array(
                'url' => $url
            ));
            $facebook->countByUrl();
        }
    }
}
