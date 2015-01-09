<?php
/**
 * File containing the {@link eZSocialNetworkSite} class
 *
 * @license GNU General Public License v2.0
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */
class eZSocialNetworkSite extends eZPersistentObject
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
            "class_name"          => "eZSocialNetworkSite",
            "sort"                => array( "id" => "asc" ),
            "name"                => "ezsocialnetwork_site"
        );
        return $definition;
    }

    public static function initialize()
    {
        $ini = eZINI::instance();
        $siteName = $ini->variable('SiteSettings', 'SiteURL');
        if (!eZSocialNetworkSite::fetchByName($siteName)) {
            $webSite = eZSocialNetworkSite::create($siteName);
            $webSite->store();
        }
    }

    public static function create($name)
    {
        $data = array(
            'site' => strtolower($name),
            'date_add' => time(),
            'date_modified' => time()
        );
        return new eZSocialNetworkSite($data);
    }

    public static function fetchByName($name, $asObject = true)
    {
        return eZPersistentObject::fetchObject(
            eZSocialNetworkSite::definition(),
            null,
            array( 'LOWER( site )' => strtolower($name) ),
            $asObject
        );
    }

    public static function fetch($id, $asObject = null)
    {
        return eZPersistentObject::fetchObject(
            eZSocialNetworkSite::definition(),
            null,
            array( 'id' => $id ),
            $asObject
        );
    }

    /*!
     Fetches a list of nodes and returns it.
    */
    public static function fetchList()
    {
        $sql = "SELECT * FROM ezsocialnetwork_site ORDER BY id ASC";
        $db = eZDB::instance();
        return $db->arrayQuery($sql, array());
    }
}
