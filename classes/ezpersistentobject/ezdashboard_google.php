<?php
/**
 * File containing the {@link eZDashBoardGoogle} class
 *
 * @license GNU General Public License v2.0
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */
class eZDashBoardGoogle extends eZPersistentObject
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
                "count" => array(
                    'name' => 'Count',
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
            "class_name"          => "eZDashBoardGoogle",
            "sort"                => array( "id" => "asc" ),
            "name"                => "ezdashboard_google"
        );
        return $definition;
    }

    public static function create($data)
    {
        $attributeData = array(
            "count"         => (isset($data['result']['metadata']['globalCounts']['count']) ? $data['result']['metadata']['globalCounts']['count'] : $data),
            "date_add"      => time(),
            "date_modified" => time()
        );
        return new eZDashBoardGoogle($attributeData);
    }

    public static function fetch($id)
    {
        $row = eZPersistentObject::fetchObject(eZDashBoardGoogle::definition(), null, array('id' => $id));
        if (!$row) {
            return false;
        }
        return $row;
    }
}
