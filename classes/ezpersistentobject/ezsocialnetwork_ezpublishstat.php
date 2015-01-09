<?php
/**
 * File containing the {@link eZSocialNetworkeZPublishStats} class
 *
 * @license GNU General Public License v2.0
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */
class eZSocialNetworkeZPublishStats extends eZPersistentObject
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
            "class_name"          => "eZSocialNetworkeZPublishStats",
            "sort"                => array( "id" => "asc" ),
            "name"                => "ezdashboard_ezpublish"
        );
        return $definition;
    }

    public static function create($count)
    {
        $data = array(
            'visit_count' => $count,
            'date_add' => time(),
            'date_modified' => time()
        );
        return new eZSocialNetworkeZPublishStats($data);
    }

    public static function fetch($id, $asObject = true)
    {
        return eZPersistentObject::fetchObject(
            eZDashBoardeZPublishStats::definition(),
            null,
            array( 'id' => $id ),
            $asObject
        );
    }

    public static function statsUrl($url)
    {
        $dashboardIni = eZINI::instance('socialnetwork.ini');
        eZURLAliasML::translate($url);
        $urlArray = explode('/', $url);
        $nodeArray = eZContentObjectTreeNode::fetch(end($urlArray), false, false);
        if ($dashboardIni->hasVariable('SocialNetworkSettings', 'eZPublishCounterHandler') && $nodeArray) {
            $ezCountHandler = $dashboardIni->variable('SocialNetworkSettings', 'eZPublishCounterHandler');
            return $ezCountHandler::fetch($nodeArray['contentobject_id'], false);
        }
        return false;
    }
}
