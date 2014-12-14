<?php
/**
 * File containing the {@link eZDashBoard} class
 *
 * @license GNU General Public License v2.0
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */
class eZDashBoard extends eZPersistentObject
{
    public function __construct($row)
    {
        parent::__construct($row);
    }

    public static function definition()
    {
        static $definition = array(
            "fields" => array(
                "id" => array(
                    'name' => 'ID',
                    'datatype' => 'integer',
                    'required' => true
                ),
                "site_id" => array(
                    'name' => 'SiteID',
                    'datatype' => 'integer',
                    'default' => '',
                    'required' => false
                ),
                "name" => array(
                    'name' => 'Name',
                    'datatype' => 'string',
                    'default' => '',
                    'required' => false
                ),
                "url" => array(
                    'name' => "Url",
                    'datatype' => 'string',
                    'default' => '',
                    'required' => false
                ),
                "hash_url" => array(
                    'name' => 'Hash',
                    'datatype' => 'string',
                    'default' => '',
                    'required' => false
                ),
                "class_identifier" => array(
                    'name' => 'ClassIdentifier',
                    'datatype' => 'string',
                    'default' => '',
                    'required' => false
                ),
                "image" => array(
                    'name' => 'Image',
                    'datatype' => 'string',
                    'default' => '',
                    'required' => false
                ),
                "ezpublishstats_id" => array(
                    'name' => 'eZ Publish Stats',
                    'datatype' => 'integer',
                    'default' => 0,
                    'required' => false
                ),
                "delicious_id" => array(
                    'name' => 'Delicious',
                    'datatype' => 'integer',
                    'default' => '',
                    'required' => false
                ),
                "googleplus_id" => array(
                    'name' => 'GooglePlusID',
                    'datatype' => 'integer',
                    'default' => '',
                    'required' => false
                ),
                "reddit_id" => array(
                    'name' => 'RedditID',
                    'datatype' => 'integer',
                    'default' => '',
                    'required' => false
                ),
                "facebook_id" => array(
                    'name' => 'FacebookID',
                    'datatype' => 'integer',
                    'default' => '',
                    'required' => false
                ),
                "linkedin_id" => array(
                    'name' => 'Linkedin',
                    'datatype' => 'integer',
                    'default' => '',
                    'required' => false
                ),
                "stumbleupon_id" => array(
                    'name' => 'StumbleUpon',
                    'datatype' => 'integer',
                    'default' => '',
                    'required' => false
                ),
                "twitter_id" => array(
                    'name' => 'Twitter',
                    'datatype' => 'integer',
                    'default' => '',
                    'required' => false
                ),
                "pinterest_id" => array(
                    'name' => 'Pinterest',
                    'datatype' => 'integer',
                    'default' => '',
                    'required' => false
                ),
                "date_create" => array(
                    'name' => 'DateCreation',
                    'datatype' => 'integer',
                    'default' => 0,
                    'required' => false
                ),
                "date_add" => array(
                    'name' => 'DateAdd',
                    'datatype' => 'integer',
                    'default' => 0,
                    'required' => false
                ),
                "date_modified" => array(
                    'name' => 'DateModified',
                    'datatype' => 'integer',
                    'default' => '',
                    'required' => true
                ),
            ),
            "keys"            => array( "id" ),
            "function_attributes" => array(
                "delicious"   => "getDelicious",
                "facebook"    => "getFacebook",
                "googleplus"  => "getGoogleplus",
                "linkedin"    => "getLinkedin",
                "pinterest"   => "getPinterest",
                "stumbleupon" => "getStumbleupon",
                "ezpublish"   => "getEzpublish",
                "twitter"     => "getTwitter"
            ),
            "set_functions" => array(
                "delicious"   => "setDelicious",
                "facebook"    => "setFacebook",
                "googleplus"  => "setGoogleplus",
                "linkedin"    => "setLinkedin",
                "pinterest"   => "setPinterest",
                "stumbleupon" => "setStumbleupon",
                "ezpublish"   => "setEzpublish",
                "twitter"     => "setTwitter"
            ),
            "increment_key"       => "id",
            "class_name"          => "eZDashBoard",
            "sort"                => array( "id" => "asc" ),
            "name"                => "ezdashboard"
        );
        return $definition;
    }


    public static function create($data)
    {
        $ini = eZINI::instance();
        $siteName = $ini->variable('SiteSettings', 'MainFrontHost');
        $ezdashboardsite = eZDashBoardSite::fetchByName($siteName);
        if (!$ezdashboardsite) {
            eZDebug::writeError("This sitename $siteName didn't exist.", __METHOD__);
            return false;
        }
        $attributeData = array(
            'site_id'         => $ezdashboardsite->attribute('id'),
            'name'            => $data['name'],
            'url'             => $data['url'],
            'hash_url'        => $data['hash_url'],
            'date_create'     => $data['date_create'],
            'class_identifier'=> $data['class_identifier'],
            'image'           => $data['image'],
            'date_add'        => time(),
            'date_modified'   => time()
        );
        return new eZDashBoard($attributeData);
    }

    public static function fetch($id)
    {
        $row = eZPersistentObject::fetchObject(self::definition(), null, array('id' => $id));
        if (!$row) {
            return false;
        }
        return $row;
    }

    /**
     * [fetchByUrl description]
     * @param  [type] $url [description]
     * @return [type]      [description]
     */
    public static function fetchByURL($url)
    {
        $row = eZPersistentObject::fetchObject(self::definition(), null, array('hash_url' => md5($url)));
        if (!$row) {
            return false;
        }
        return $row;
    }

    public function linkedToAuthor($authorID)
    {
        return eZDashBoard::storeDashBoardInAuthor($this->attribute('id'), $authorID);
    }

    public static function storeDashBoardInAuthor($dashboardID, $authorID)
    {
        $db = eZDB::instance();
        return $db->query("INSERT INTO `ezdashboard_dashboard_author` (`dashboard_id`, `author_id`)
                            VALUES ('".$dashboardID."', '".$authorID."');");
    }

    public static function fetchListByTime($strtotime)
    {
        $time = strtotime($strtotime);
        $result = eZPersistentObject::fetchObjectList(eZDashBoard::definition(),
                                                    array('id'),
                                                    array(
                                                        'date_create' => array('>', $time)
                                                    ),
                                                    null,
                                                    null,
                                                    null);
        if (!$result) {
            return false;
        }
        $returnID = array();
        foreach ($result as $row) {
            $returnID[]=$row['id'];
        }
        return $returnID;
    }

    public function getURL()
    {
        return 'http://'.$this->getSite()->attribute('site') . '/' . $this->attribute('url');
    }

    public function getSite()
    {
        if (!isset($this->Site)) {
            $this->Site = eZDashBoardSite::fetch($this->attribute('site_id'), true);
        }
        return $this->Site;
    }

    /**
     * [getFacebook description]
     * @return [type] [description]
     * @api
     */
    public function getFacebook()
    {
        if (!isset($this->facebook)) {
            $this->facebook = eZDashBoardFacebook::fetch($this->attribute("facebook_id"));
        }
        return $this->facebook;
    }

    /**
     * [setFacebook description]
     * @param [type] $facebook [description]
     */
    public function setFacebook($data)
    {
        if (isset($data[0]) && is_array($data[0])) {
            $data = $data[0];
        }
        if ($this->attribute('facebook_id')) {
            $facebook = eZDashBoardFacebook::fetch($this->attribute('facebook_id'));
            $facebook->fillData($data);
            $facebook->setAttribute('date_modified', time());
        } else {
            $facebook = eZDashBoardFacebook::create($data);
        }
        if (!($facebook instanceof eZDashBoardFacebook)) {
            eZDebug::writeError("Undefined attribute facebook, cannot set",
                                 "eZDashBoardFacebook");
        }
        $this->facebook = $facebook;
    }

    /**
     * [getGoogleplus description]
     * @return [type] [description]
     * @api
     */
    public function getGoogleplus()
    {
        if (!isset($this->googleplus)) {
            $this->googleplus = eZDashBoardGoogle::fetch($this->attribute("googleplus_id"));
        }
        return $this->googleplus;
    }

    /**
     * [setGoogleplus description]
     * @param [type] $data [description]
     */
    public function setGoogleplus($data)
    {
        if (isset($data[0]) && is_array($data[0])) {
            $data = $data[0];
        }
        if ($this->attribute('googleplus_id')) {
            $googleplus = eZDashBoardGoogle::fetch($this->attribute('googleplus_id'));
            $googleplus->setAttribute('count', $data['result']['metadata']['globalCounts']['count']);
            $googleplus->setAttribute('date_modified', time());
        } else {
            $googleplus = eZDashBoardGoogle::create($data);
        }
        if (!($googleplus instanceof eZDashBoardGoogle)) {
            eZDebug::writeError("Undefined attribute google, cannot set",
                                 "eZDashBoardGoogle");
        }
        $this->googleplus = $googleplus;
    }

    /**
     * [getEzpublish description]
     * @return [type] [description]
     * @api
     */
    public function getEzpublish()
    {
        if (!isset($this->ezpublish)) {
            $this->ezpublish = eZDashBoardeZPublishStats::fetch($this->attribute("ezpublishstats_id"));
        }
        return $this->ezpublish;
    }

    /**
     * [setEzpublish description]
     * @param [type] $ezpublish [description]
     */
    public function setEzpublish($data)
    {
        if (isset($data[0]) && is_array($data[0])) {
            $data = $data[0];
        }
        if ($this->attribute('ezpublishstats_id')) {
            $ezpublish = eZDashBoardeZPublishStats::fetch($this->attribute('ezpublishstats_id'));
            $ezpublish->setAttribute('visit_count', $data['count']);
            $ezpublish->setAttribute('date_modified', time());
        } else {
            $ezpublish = eZDashBoardeZPublishStats::create($data['count']);
        }
        if (!($ezpublish instanceof eZDashBoardeZPublishStats)) {
            eZDebug::writeError("Undefined attribute ezpublish, cannot set",
                                 "eZDashBoardeZPublishStats");
        }
        $this->ezpublish = $ezpublish;
    }

    /**
     * [getDelicious description]
     * @return [type] [description]
     * @api
     */
    public function getDelicious()
    {
        return $this->attribute('delicious_id');
    }

    /**
     * [setDelicious description]
     * @return $delicious [description]
     * @api
     */
    public function setDelicious($delicious)
    {
        $this->setAttribute("delicious_id", $delicious);
    }

    /**
     * [getLinkedin description]
     * @return [type] [description]
     * @api
     */
    public function getLinkedin()
    {
        return $this->attribute('linkedin_id');
    }

    /**
     * [setLinkedin description]
     * @return $delicious [description]
     * @api
     */
    public function setLinkedin($linkedin)
    {
        if (isset($linkedin['count'])) {
            $linkedin = $linkedin['count'];
        }
        $this->setAttribute("linkedin_id", $linkedin);
    }

    /**
     * [getPinterest description]
     * @return [type] [description]
     * @api
     */
    public function getPinterest()
    {
        return $this->attribute('pinterest_id');
    }

    /**
     * [setPinterest description]
     * @return $delicious [description]
     * @api
     */
    public function setPinterest($pinterest)
    {
        if (isset($pinterest['count'])) {
            $pinterest = $pinterest['count'];
        }
        $this->setAttribute("pinterest_id", $pinterest);
    }

    /**
     * [getStumbleupon description]
     * @return [type] [description]
     * @api
     */
    public function getStumbleupon()
    {
        return $this->attribute('stumbleupon_id');
    }

    /**
     * [setStumbleupon description]
     * @return $stumbleupon [description]
     * @api
     */
    public function setStumbleupon($stumbleupon)
    {
        if (isset($stumbleupon['views'])) {
            $stumbleupon = $stumbleupon['views'];
            $this->setAttribute("stumbleupon_id", $stumbleupon);
        } else {
            $this->setAttribute("stumbleupon_id", 0);
        }
    }

    /**
     * [getTwitter description]
     * @return [type] [description]
     * @api
     */
    public function getTwitter()
    {
        return $this->attribute('twitter_id');
    }

    /**
     * [setTwitter description]
     * @return $twitter [description]
     * @api
     */
    public function setTwitter($twitter)
    {
        $this->setAttribute("twitter_id", $twitter);
    }

    public function store($fieldFilters = null)
    {
        $db = eZDB::instance();
        $socialINI = eZINI::instance('social.ini');
        $db->begin();
        if ($socialINI->hasVariable('SocialSettings', 'TypeHandler')) {
            $socialHandlers = $socialINI->variable('SocialSettings', 'TypeHandler');
            if (!empty($socialHandlers)) {
                foreach ($socialHandlers as $socialHandler) {
                    $attribute = strtolower($socialHandler);
                    $attributeID = $attribute. '_id';
                    if (isset($this->$attribute) && $this->$attribute) {
                        $this->$attribute->store();
                        if (!$this->attribute($attributeID)) {
                            $this->setAttribute($attributeID, $this->$attribute->attribute('id'));
                        }
                    }
                }
            }
        }
        if (isset($this->ezpublish) && $this->ezpublish) {
            $this->ezpublish->store();
            if (!$this->attribute('ezpublishstats_id')) {
                $this->setAttribute('ezpublishstats_id', $this->ezpublish->attribute('id'));
            }
        }
        eZPersistentObject::store($fieldFilters);
        $db->commit();
    }

    /*!
     Fetches a list of nodes and returns it. Offset and limitation can be set if needed.
    */
    public static function fetchList($offset = false, $limit = false)
    {
        $sql = "SELECT * FROM ezdashboard ORDER BY date_add DESC";
        $parameters = array();
        if ($offset !== false) {
            $parameters['offset'] = $offset;
        }
        if ($limit !== false) {
            $parameters['limit'] = $limit;
        }
        $db = eZDB::instance();
        return $db->arrayQuery($sql, $parameters);
    }
}
