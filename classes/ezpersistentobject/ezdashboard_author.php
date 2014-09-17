<?php
/**
 * File containing the {@link eZDashBoardAuthor} class
 *
 * @license GNU General Public License v2.0
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */
class eZDashBoardAuthor extends eZPersistentObject
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
                "name" => array(
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
            "class_name"          => "eZDashBoardAuthor",
            "sort"                => array( "id" => "asc" ),
            "name"                => "ezdashboard_author"
        );
        return $definition;
    }

    public static function create($name)
    {
        $data = array(
            'name' => $name,
            'date_add' => time(),
            'date_modified' => time()
        );
        return new eZDashBoardAuthor($data);
    }

    public static function fetchByName($name, $asObject = true)
    {
        return eZPersistentObject::fetchObject(eZDashBoardAuthor::definition(),
                                                null,
                                                array( 'name' => $name),
                                                $asObject);
    }
}
