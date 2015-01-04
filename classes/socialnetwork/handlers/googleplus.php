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
    public function statsByUrlAndByApi()
    {
        return GooglePlusAPI::statsUrl(array(
            'url' => $this->url
        ));
    }

    /**
     * [shared description]
     * @param  [type] $url [description]
     * @return [type]      [description]
     * @api
     */
    public static function statsUrl($url)
    {
        if (!empty($url) && is_string($url)) {
            $googleplus = new GooglePlus(array(
                'url' => $url
            ));
            return $googleplus->statsByUrlAndByApi();
        }
        return false;
    }
}
