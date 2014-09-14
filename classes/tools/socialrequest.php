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
    public function request($hostMethod, $params = false)
    {
        $url = "";
        if (!empty($params) && is_array($params)) {
            $url .= "?";
            foreach ($params as $key => $value) {
                if ($value) {
                    $url .= $key . '=' .$value . "&";
                    unset($params[$key]);
                }
            }
            $url = substr($url, 0, -1);
        }
        return $this->call($hostMethod.$url, $params);
    }

    /**
     * [call description]
     * @param  [type] $url [description]
     * @return [type]      [description]
     */

    public function call($url, $jsonPost)
    {
        $curl = new CurlHttpClient($url);
        $curl->setOption($this->configCurl);
        if ($jsonPost) {
            $curl->setOption(array(CURLOPT_POSTFIELDS => $jsonPost));
        }
        return $curl->getResponse();
    }
}
