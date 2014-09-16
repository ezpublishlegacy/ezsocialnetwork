<?php
/**
 * File containing the {@link eZDashBoardSite} class
 *
 * @license GNU General Public License v2.0
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */
class eZDashBoardSite extends eZPersistentObject
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
                "site" => array(
                    'name' => 'Site',
                    'datatype' => 'string',
                    'default' => '',
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
                    'default' => 0,
                    'required' => false
                ),
            ),
            "keys"                => array( "id" ),
            "function_attributes" => array(
            ),
            "increment_key"       => "id",
            "class_name"          => "eZDashBoardSite",
            "sort"                => array( "id" => "asc" ),
            "name"                => "ezdashboard_site"
        );
        return $definition;
    }

    public static function initialize()
    {
        $ini = eZINI::instance();
        $siteName = $ini->variable('SiteSettings', 'SiteURL');
        if (!eZDashBoardSite::fetchByName($siteName)) {
            $ezdash = eZDashBoardSite::create($siteName);
            $ezdash->store();
        }
    }

    public static function create($name)
    {
        $data = array(
            'site' => strtolower($name),
            'date_add' => time(),
            'date_modified' => time()
        );
        return new eZDashBoardSite($data);
    }

    public static function fetchByName($name, $asObject = true)
    {
        return eZPersistentObject::fetchObject(eZDashBoardSite::definition(),
                                                null,
                                                array( 'LOWER( site )' => strtolower($name) ),
                                                $asObject);
    }
}
