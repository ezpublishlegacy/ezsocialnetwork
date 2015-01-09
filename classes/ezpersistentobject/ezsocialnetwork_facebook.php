<?php
/**
 * File containing the {@link eZSocialNetworkFacebook} class
 *
 * @license GNU General Public License v2.0
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */
class eZSocialNetworkFacebook extends eZPersistentObject
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
                    'name' => 'ShareCount',
                    'datatype' => 'integer',
                    'default' => '',
                    'required' => false
                ),
                "like_count" => array(
                    'name' => 'LikeCount',
                    'datatype' => 'integer',
                    'default' => '',
                    'required' => false
                ),
                "comment_count" => array(
                    'name' => "CommentCount",
                    'datatype' => 'integer',
                    'default' => '',
                    'required' => false
                ),
                "total_count" => array(
                    'name' => 'TotalCount',
                    'datatype' => 'integer',
                    'default' => '',
                    'required' => false
                ),
                "click_count" => array(
                    'name' => 'ClickCount',
                    'datatype' => 'integer',
                    'default' => '',
                    'required' => false
                ),
                "commentsbox_count" => array(
                    'name' => 'CommentsBoxCount',
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
            "class_name"          => "eZSocialNetworkFacebook",
            "sort"                => array( "id" => "asc" ),
            "name"                => "ezsocialnetwork_facebook"
        );
        return $definition;
    }

    public static function create($data)
    {
        $attributeData = array(
            "share_count"       => (isset($data["share_count"]) ? $data["share_count"] : 0),
            "like_count"        => (isset($data["like_count"]) ? $data["like_count"] : 0),
            "comment_count"     => (isset($data["comment_count"]) ? $data["comment_count"] : 0),
            "total_count"       => (isset($data["total_count"]) ? $data["total_count"] : 0),
            "click_count"       => (isset($data["click_count"]) ? $data["click_count"] : 0),
            "commentsbox_count" => (isset($data["commentsbox_count"]) ? $data["commentsbox_count"] : 0),
            "date_add"          => time(),
            "date_modified"     => time()
        );
        return new eZSocialNetworkFacebook($attributeData);
    }

    public function fillData($row)
    {
        if (!is_array($row)) {
            return;
        }
        $def = $this->definition();

        foreach ($def["fields"] as $key => $item) {
            if (isset($item['name'])) {
                $item = $item['name'];
            }
            $this->$item = isset($row[$key]) ? $row[$key] : $this->$item;
        }
        return true;
    }

    public static function fetch($id)
    {
        $row = eZPersistentObject::fetchObject(eZSocialNetworkFacebook::definition(), null, array('id' => $id));
        if (!$row) {
            return false;
        }
        return $row;
    }
}
