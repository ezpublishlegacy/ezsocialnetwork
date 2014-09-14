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

    public function statsByUrlAndByApi()
    {
        return FacebookAPI::statsUrl(array(
            'urls' => $this->urls,
            'format' => $this->json
        ));
    }

    /**
     * [shared description]
     * @param  [type] $url [description]
     * @return [type]      [description]
     * @api
     */
    public static function statsUrl($urls, $type = 'api')
    {
        if (!empty($urls) && is_string($urls)) {
            $facebook = new Facebook(array(
                'urls' => $urls
            ));
            switch (strtolower($type)) {
                default:
                case 'api':
                    return $facebook->statsByUrlAndByApi();
                    break;
                case 'graph':
                    return $facebook->statsByUrlAndByGraph();
                    break;
                case 'fql':
                    return $facebook->statsByUrlAndByFQL();
                    break;
            }
        }
        return false;
    }

    /**
     * [statsByUrlAndByGraph description]
     * @return [type] [description]
     */
    public function statsByUrlAndByGraph()
    {
        return FacebookGraph::statsUrl(array(
            'urls' => $this->urls,
        ));
    }

    /**
     * [countUrlStatsByFQl description]
     * @var  String $url
     * @return [type] [description]
     * @api
     */
    public function statsByUrlAndByFQL()
    {
        if ($this->urls) {
            return FacebookFQL::statsUrl(array(
                'urls' => $this->urls
            ));
        }
    }
}
