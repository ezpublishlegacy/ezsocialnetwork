<?php
/**
 * File containing the {@link eZSocialNetwork} class
 *
 * @license GNU General Public License v2.0
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */
class eZSocialNetwork extends eZPersistentObject
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
            "class_name"          => "eZSocialNetwork",
            "sort"                => array( "id" => "asc" ),
            "name"                => "ezsocialnetwork"
        );
        return $definition;
    }

    public static function create($data)
    {
        $ini = eZINI::instance();
        $siteName = $ini->variable('SiteSettings', 'MainFrontHost');
        $ezsocialnetworksite = eZSocialNetworkSite::fetchByName($siteName);
        if (!$ezsocialnetworksite) {
            eZDebug::writeError("This sitename $siteName didn't exist.", __METHOD__);
            return false;
        }
        $attributeData = array(
            'site_id'         => $ezsocialnetworksite->attribute('id'),
            'name'            => $data['name'],
            'url'             => $data['url'],
            'hash_url'        => $data['hash_url'],
            'date_create'     => $data['date_create'],
            'class_identifier'=> $data['class_identifier'],
            'image'           => $data['image'],
            'date_add'        => time(),
            'date_modified'   => time()
        );
        return new eZSocialNetwork($attributeData);
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
        return eZSocialNetwork::storeDashBoardInAuthor($this->attribute('id'), $authorID);
    }

    public static function storeDashBoardInAuthor($socialNetworkID, $authorID)
    {
        $db = eZDB::instance();
        return $db->query("INSERT INTO `ezsocialnetwork_dashboard_author` (`dashboard_id`, `author_id`)
                            VALUES ('".$socialNetworkID."', '".$authorID."');");
    }

    public function getAuthor($asObject = true)
    {
        $db = eZDB::instance();
        $result = $db->arrayQuery(
            "SELECT
                ezda.id,
                ezda.name,
                ezda.date_add,
                ezda.date_modified
            FROM ezsocialnetwork as ezd
            LEFT JOIN ezsocialnetwork_dashboard_author as ezdda on (ezd.id = ezdda.dashboard_id)
            LEFT JOIN ezsocialnetwork_author as ezda on (ezdda.author_id = ezda.id)
            WHERE ezd.id = '".$this->attribute('hash_url')."'"
        );
        if (!$result) {
            return false;
        }
        if (!$asObject) {
            return $result[0];
        }
        return new eZSocialNetworkAuthor($result[0]);
    }

    public static function fetchListByTime($strtotime)
    {
        $time = strtotime($strtotime);

        $result = eZPersistentObject::fetchObjectList(
            eZSocialNetwork::definition(),
            array('id'),
            array(
                'date_create' => array('>', $time)
            ),
            array(
                'date_modified' => 'DESC'
            ),
            null,
            null
        );
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
            $this->Site = eZSocialNetworkSite::fetch($this->attribute('site_id'), true);
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
            $this->facebook = eZSocialNetworkFacebook::fetch($this->attribute("facebook_id"));
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
            $facebook = eZSocialNetworkFacebook::fetch($this->attribute('facebook_id'));
            $facebook->fillData($data);
            $facebook->setAttribute('date_modified', time());
        } else {
            $facebook = eZSocialNetworkFacebook::create($data);
        }
        if (!($facebook instanceof eZSocialNetworkFacebook)) {
            eZDebug::writeError(
                "Undefined attribute facebook, cannot set",
                "eZSocialNetworkFacebook"
            );
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
            $this->googleplus = eZSocialNetworkGoogle::fetch($this->attribute("googleplus_id"));
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
            $googleplus = eZSocialNetworkGoogle::fetch($this->attribute('googleplus_id'));
            $googleplus->setAttribute('count', $data['result']['metadata']['globalCounts']['count']);
            $googleplus->setAttribute('date_modified', time());
        } else {
            $googleplus = eZSocialNetworkGoogle::create($data);
        }
        if (!($googleplus instanceof eZSocialNetworkGoogle)) {
            eZDebug::writeError(
                "Undefined attribute google, cannot set",
                "eZSocialNetworkGoogle"
            );
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
            $this->ezpublish = eZSocialNetworkeZPublishStats::fetch($this->attribute("ezpublishstats_id"));
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
            $ezpublish = eZSocialNetworkeZPublishStats::fetch($this->attribute('ezpublishstats_id'));
            $ezpublish->setAttribute('visit_count', $data['count']);
            $ezpublish->setAttribute('date_modified', time());
        } else {
            $ezpublish = eZSocialNetworkeZPublishStats::create($data['count']);
        }
        if (!($ezpublish instanceof eZSocialNetworkeZPublishStats)) {
            eZDebug::writeError(
                "Undefined attribute ezpublish, cannot set",
                "eZSocialNetworkeZPublishStats"
            );
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
        $sql = "SELECT ezd.*, ezda.name as author FROM ezsocialnetwork as ezd
                LEFT JOIN ezsocialnetwork_dashboard_author as ezdda on (ezd.id = ezdda.dashboard_id)
                LEFT JOIN ezsocialnetwork_author as ezda on (ezdda.author_id = ezda.id)
                ORDER BY date_add DESC";
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

    /**
     * Build all stats by social network
     * @param  string                   $uri [description]
     * @return array                    stats facebook, twitter ...
     * @date   2015-01-04T16:49:03+0100
     */
    public static function getStats($uri)
    {
        $social      = eZSocialNetwork::fetchByURL($uri);
        $author      = $social->getAuthor();
        $facebook    = $social->getFacebook();
        $googleplus  = $social->getGoogleplus();
        $ezpublish   = $social->getEzpublish();
        $delicious   = $social->getDelicious();
        $linkedin    = $social->getLinkedin();
        $pinterest   = $social->getPinterest();
        $stumbleupon = $social->getStumbleupon();
        $twitter     = $social->getTwitter();

        //count
        $count           = 0;
        $facebookCount   = 0;
        $googlePlusCount = 0;
        $eZpublishCount  = 0;
        if ($facebook) {
            $facebookCount = $facebook->attribute('total_count');
            $count         += $facebookCount;
        }
        if ($googleplus) {
            $googlePlusCount = $googleplus->attribute('count');
            $count           += $googlePlusCount;
        }
        if ($ezpublish) {
            $eZpublishCount = $ezpublish->attribute('visit_count');
            // $count       += $eZpublishCount;
        }
        $count += $delicious;
        $count += $linkedin;
        $count += $pinterest;
        $count += $stumbleupon;
        $count += $twitter;

        return array(
            'author'      => ($author ? $author->attribute('name') : ""),
            'facebook'    => $facebookCount,
            'googleplus'  => $googlePlusCount,
            'ezpublish'   => $eZpublishCount,
            'delicious'   => $delicious,
            'linkedin'    => $linkedin,
            'pinterest'   => $pinterest,
            'stumbleupon' => $stumbleupon,
            'twitter'     => $twitter,
            'total'       => $count
        );
    }
}
