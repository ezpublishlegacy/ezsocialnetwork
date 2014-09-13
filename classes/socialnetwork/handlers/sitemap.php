<?php
/**
 * @licence http://www.gnu.org/licenses/gpl-2.0.txt GNU GPLv2
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */

class Sitemap extends SocialModel
{
    public $url = "";
    public $timeout = 5;
    public $json = 'json';

    /**
     * [countSharesTweetByUrl description]
     * @return [type] [description]
     * @api
     */
    public function getContent()
    {
        return SitemapAPI::getContent(array(
            'url' => $this->url
        ));
    }
}
