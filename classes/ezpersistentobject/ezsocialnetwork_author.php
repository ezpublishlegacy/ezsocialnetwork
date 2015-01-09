<?php
/**
 * File containing the {@link eZSocialNetworkAuthor} class
 *
 * @license GNU General Public License v2.0
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */
class eZSocialNetworkAuthor extends eZPersistentObject
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
            "class_name"          => "eZSocialNetworkAuthor",
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
        return new eZSocialNetworkAuthor($data);
    }

    public static function fetchByName($name, $asObject = true)
    {
<<<<<<< HEAD:classes/ezpersistentobject/ezdashboard_author.php
        return eZPersistentObject::fetchObject(eZDashBoardAuthor::definition(),
=======
        return eZPersistentObject::fetchObject(eZSocialNetworkAuthor::definition(),
>>>>>>> [SocialNetwor] rename all extension files:classes/ezpersistentobject/ezsocialnetwork_author.php
                                                null,
                                                array( 'name' => $name),
                                                $asObject);
    }
}
