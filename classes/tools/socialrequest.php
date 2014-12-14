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
        $dashboardINI = eZINI::instance('dashboard.ini');
        ezpEvent::getInstance()->filter('socialnetwork/sharecount',
            array(
                'social' => get_class($this),
                'url' => $url,
            )
        );
        if ($dashboardINI->variable('DashBoardSettings', 'DevelopmentMode') === 'enabled') {
            $data['pack_level'] = 0;
            $class = strtolower(get_class($this));
            return file_get_contents('extension/ezdashboard/tests/'.$class.'.json');
        } else {
            $curl = new CurlHttpClient($url);
            $curl->setOption($this->configCurl);
            if ($jsonPost) {
                $curl->setOption(array(
                    CURLOPT_POSTFIELDS => $jsonPost,
                    CURLOPT_USERAGENT  => $dashboardINI->variable('DashBoardSettings', 'UserAgent')
                ));
            }
            return $curl->getResponse();
        }
    }

    /**
     * [requestAllSocialNetwork description]
     * @return [type] [description]
     */
    public static function requestAllSocialNetwork($args, $method)
    {
        $socialINI = eZINI::instance('social.ini');
        $statsUrl             = array();
        if ($socialINI->hasVariable('SocialSettings', 'TypeHandler')) {
            $socialHandlers = $socialINI->variable('SocialSettings', 'TypeHandler');
            if (!empty($socialHandlers)) {
                foreach ($socialHandlers as $socialHandler) {
                    if (!empty($socialHandler) && class_exists($socialHandler) && method_exists($socialHandler, $method)) {
                        $statsUrl[strtolower($socialHandler)] = call_user_func(array( $socialHandler, $method ), $args);
                    }
                }
            }
        }
        return $statsUrl;
    }
}
