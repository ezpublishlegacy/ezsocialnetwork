<?php
/**
 * @licence http://www.gnu.org/licenses/gpl-2.0.txt GNU GPLv2
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */

class Linkedin extends SocialModel
{
    public $url = "";
    public $timeout = 5;
    public $json = 'json';
    public $lang = 'fr_FR';
    public $callback = false;

    /**
     * [countSharesTweetByUrl description]
     * @return [type] [description]
     * @api
     */
    public function statsByUrlAndByApi()
    {
        return LinkedinAPI::statsUrl(array(
            'url' => $this->url,
            'format' => $this->json,
            'lang' => $this->lang,
            'callback' => $this->callback
        ));
    }

    /**
     * [shared description]
     * @param  [type] $url [description]
     * @return [type]      [description]
     */
    public static function statsUrl($url)
    {
        if (!empty($url) && is_string($url)) {
            $linkedin = new Linkedin(array(
                'url' => $url
            ));
            return $linkedin->statsByUrlAndByApi();
        }
        return false;
    }
}
