<?php
/**
 * @license GNU General Public License v2.0
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */

$cli->output("Prepare last content on this eZ Publish...");
$socialnetworkIni   = eZINI::instance('socialnetwork.ini');
$db                 = eZDB::instance();
// disabled binary log on this session mysqli
if ($socialnetworkIni->hasVariable('SocialNetworkSettings', 'BinaryLog') &&
    $socialnetworkIni->variable('SocialNetworkSettings', 'BinaryLog') == "enabled") {
    $db->query("set sql_log_bin = 0;");
}
$classArray         = array();
if ($socialnetworkIni->hasVariable('ContentSettings', 'ClassAvailable')) {
    $classArray     = $socialnetworkIni->variable('ContentSettings', 'ClassAvailable');
}
$imageAttributeName = $socialnetworkIni->variable('ContentSettings', 'AttributeImageName');
$rootNode           = 2;
$now                = strtotime(date('Y-m-d', time()));
$aftertytime        = strtotime(date('Y-m-d', time()-(30 * 24 * 60 * 60)));
$params             = array(
    'ClassFilterArray' => $classArray,
    'ClassFilterType'  => true,
    'Depth'            => false,
    'Limitation'       => array(),
    'LoadDataMap'      => false,
    'SortBy'           => array( 'published', true ),
    'AttributeFilter'  => array(
        'and',
        array( 'published', '>', $aftertytime ),
        array( 'published', '<=', $now ),
        array( 'visibility', '=', true ) // Do not fetch hidden nodes even when ShowHiddenNodes=true
    )
);
eZSocialNetworkSite::initialize();
$nodes = eZContentObjectTreeNode::subTreeByNodeID($params, $rootNode);
$cli->output("There are ". count($nodes). " nodes");
if (count($nodes)) {
    foreach ($nodes as $key => $node) {
        $url = $node->urlAlias();
        $cli->output("Working on this content ". $url);
        if (eZSocialNetwork::fetchByURL($url)) {
            $cli->output("Already existed");
            continue;
        }
        $datamap                           = $node->dataMap();
        $attributeData                     = array();
        $attributeData['name']             = $node->attribute('name');
        $attributeData['url']              = $url;
        $attributeData['hash_url']         = md5($url);
        $attributeData['date_create']      = $node->object()->attribute("published");
        $attributeData['class_identifier'] = $node->attribute("class_identifier");
        foreach ($imageAttributeName as $key => $attributeName) {
            if (isset($datamap[$attributeName]) && $datamap[$attributeName]) {
                $imageReference         = $datamap[$attributeName]->content()->imageAlias('reference');
                $attributeData['image'] = $imageReference['url'];
                break;
            }
        }
        
        $db->begin();
        $ezdash = eZSocialNetwork::create($attributeData);
        $ezdash->store();

        // @todo these rows are not standard
        if (isset($datamap['author'])  && $datamap['author']->hasContent()) {
            $author = $datamap['author']->content();
            if ($author instanceof eZContentObject) {
                $authorName   = trim(str_replace("  ", " ", $author->attribute('name')));
            } else {
                $authorName   = trim(str_replace("  ", " ", $author));
            }
            $ezdashauthor = eZSocialNetworkAuthor::fetchByName($authorName);
            if (!$ezdashauthor) {
                $ezdashauthor = eZSocialNetworkAuthor::create($authorName);
                $ezdashauthor->store();
            }
            $ezdash->linkedToAuthor($ezdashauthor->attribute('id'));
        }
        $db->commit();
        $cli->output("Done \n");
    }
}

$script->shutdown();
