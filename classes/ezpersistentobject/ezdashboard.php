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
                "image" => array(
                    'name' => 'Image',
                    'datatype' => 'string',
                    'default' => '',
                    'required' => false
                ),
                "creator_id" => array(
                    'name' => 'Creator',
                    'datatype' => 'integer',
                    'default' => '',
                    'required' => false
                ),
                "author" => array(
                    'name' => 'Author',
                    'datatype' => 'string',
                    'default' => '',
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
                "date_add" => array(
                    'name' => 'DateAdd',
                    'datatype' => 'integer',
                    'default' => '',
                    'required' => false
                ),
                "date_modified" => array(
                    'name' => 'DateModified',
                    'datatype' => 'integer',
                    'default' => '',
                    'required' => false
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

    public static function create($name)
    {
        $ini = eZINI::instance();
        $data = array(

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
