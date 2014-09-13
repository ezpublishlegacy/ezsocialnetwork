<?php
/**
 * File containing the {@link eZDashBoardFacebook} class
 *
 * @license GNU General Public License v2.0
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */
class eZDashBoardFacebook extends eZPersistentObject
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
                "share_count" => array(
                    'name' => 'SiteID',
                    'datatype' => 'integer',
                    'default' => '',
                    'required' => false
                ),
                "like_count" => array(
                    'name' => 'Name',
                    'datatype' => 'integer',
                    'default' => '',
                    'required' => false
                ),
                "comment_count" => array(
                    'name' => "Url",
                    'datatype' => 'integer',
                    'default' => '',
                    'required' => false
                ),
                "total_count" => array(
                    'name' => 'Hash',
                    'datatype' => 'integer',
                    'default' => '',
                    'required' => false
                ),
                "click_count" => array(
                    'name' => 'Image',
                    'datatype' => 'integer',
                    'default' => '',
                    'required' => false
                ),
                "commentsbox_count" => array(
                    'name' => 'Creator',
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
                )
            ),
            "keys"                => array( "id" ),
            "function_attributes" => array(
            ),
            "increment_key"       => "id",
            "class_name"          => "eZDashBoardFacebook",
            "sort"                => array( "id" => "asc" ),
            "name"                => "ezdashboard_facebook"
        );
        return $definition;
    }
}
