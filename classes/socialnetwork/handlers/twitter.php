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
     */
    public function statsByUrlAndByApi()
    {
        return TwitterAPI::statsUrl($this->url);
    }

    /**
     * [shared description]
     * @param  String $url [description]
     * @return [type]      [description]
     * @api
     */
    public static function statsUrl($url)
    {
        if (!empty($url) && is_string($url)) {
            $twitter = new Twitter(array(
                'url' => $url
            ));
            return $twitter->statsByUrlAndByApi();
        }
        return false;
    }
}
