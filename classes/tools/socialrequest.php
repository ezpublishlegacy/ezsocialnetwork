<?php
/**
 * @licence http://www.gnu.org/licenses/gpl-2.0.txt GNU GPLv2
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */

class SocialRequest
{
    protected $configCurl = array();
    protected static $_instance = null;

    /**
     * [request description]
     * @param  [type] $hostMethod [description]
     * @param  array  $params     [description]
     * @return [type]             [description]
     */
    public function request($hostMethod, $params = array())
    {
        if (!empty($params)) {
            $url = "?";
            foreach ($params as $key => $param) {
                $url .= $key . '=' .$param . "&";
            }
            $url = substr($url, 0, -1);
        }
        return $this->call($hostMethod.$url);
    }

    /**
     * [call description]
     * @param  [type] $url [description]
     * @return [type]      [description]
     */
    public function call($url)
    {
        $curl = new CurlHttpClient($url);
        $curl->setOption($this->configCurl);
        return $curl->getResponse();
    }
}
