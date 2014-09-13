<?php
/**
 * @licence http://www.gnu.org/licenses/gpl-2.0.txt GNU GPLv2
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */

class Facebook extends SocialModel
{
    public $urls = "";
    public $timeout = 5;
    public $json = 'json';

    /**
     * [countSharesTweetByUrl description]
     * @return [type] [description]
     * @api
     */
    public function countByUrl()
    {
        return FacebookAPI::linkGetStats(array(
            'method' => 'links.getStats',
            'urls' => $this->urls,
            'format' => $this->json
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
            $facebook = new Facebook(array(
                'urls' => $urls
            ));
            $facebook->countByUrl();
        }
    }
}
