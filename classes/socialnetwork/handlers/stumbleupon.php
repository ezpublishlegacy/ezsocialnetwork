<?php
/**
 * @licence http://www.gnu.org/licenses/gpl-2.0.txt GNU GPLv2
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */

class Stumbleupon extends SocialModel
{
    public $url = "";
    public $timeout = 5;

    /**
     * [countSharesTweetByUrl description]
     * @return [type] [description]
     * @api
     */
    public function statsByUrlAndByApi()
    {
        return StumbleUponAPI::statsUrl(array(
            'url' => $this->url
        ));
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
            $stumbleupon = new Stumbleupon(array(
                'url' => $url
            ));
            return  $stumbleupon->statsByUrlAndByApi();
        }
        return false;
    }
}
