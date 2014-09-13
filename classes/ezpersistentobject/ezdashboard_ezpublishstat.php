<?php
/**
 * File containing the {@link eZDashBoardeZPublishStats} class
 *
 * @license GNU General Public License v2.0
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */
class eZDashBoardeZPublishStats extends eZPersistentObject
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
                "visit_count" => array(
                    'name' => 'VisitCount',
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
            "class_name"          => "eZDashBoardeZPublishStats",
            "sort"                => array( "id" => "asc" ),
            "name"                => "ezdashboard_site"
        );
        return $definition;
    }

    public static function create($name)
    {
        $data = array(
            'visit_count' => strtolower($name),
            'date_add' => time(),
            'date_modified' => time()
        );
        return new eZDashBoardeZPublishStats($data);
    }

    public static function fetch($id, $asObject = null)
    {
        return eZPersistentObject::fetchObject(eZDashBoardeZPublishStats::definition(),
                                                null,
                                                array( 'id' => $id ),
                                                $asObject);
    }
}
