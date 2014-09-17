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
                "delicious" => array(
                    'name' => 'Delicious',
                    'datatype' => 'integer',
                    'default' => '',
                    'required' => false
                ),
                "google_id" => array(
                    'name' => 'GoogleID',
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
                "linkedin" => array(
                    'name' => 'Linkedin',
                    'datatype' => 'integer',
                    'default' => '',
                    'required' => false
                ),
                "stumbleupon" => array(
                    'name' => 'StumbleUpon',
                    'datatype' => 'integer',
                    'default' => '',
                    'required' => false
                ),
                "twitter" => array(
                    'name' => 'Twitter',
                    'datatype' => 'integer',
                    'default' => '',
                    'required' => false
                ),
                "pinterest" => array(
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
            "keys"                => array( "id" ),
            "function_attributes" => array(
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
}
