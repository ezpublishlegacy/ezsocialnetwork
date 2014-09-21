<?php
/**
 * @license GNU General Public License v2.0
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */

$cli->output("Prepare last content on this eZ Publish...");
$dashboardIni = eZINI::instance('dashboard.ini');
$db = eZDB::instance();
$classArray = array();
if ($dashboardIni->hasVariable('ContentSettings', 'ClassAvailable')) {
    $classArray = $dashboardIni->variable('ContentSettings', 'ClassAvailable');
}
$imageAttributeName = $dashboardIni->variable('ContentSettings', 'AttributeImageName');
$rootNode     = 2;
$now = time();
$aftertytime = mktime(0, 0, 0, date('m', time()), date('d', time()) - 120, date('Y', time()));
$params = array(
    'ClassFilterArray' => $classArray,
    'ClassFilterType'  => true,
    'Depth'            => false,
    'Limitation'       => array(),
    'LoadDataMap'      => false,
    'SortBy'           => array( 'published', false ),
    'AttributeFilter'  => array(
        'and',
        array( 'published', '>', $aftertytime ),
        array( 'published', '<=', $now ),
        array( 'visibility', '=', true ) // Do not fetch hidden nodes even when ShowHiddenNodes=true
    )
);
eZDashBoardSite::initialize();
$nodes = eZContentObjectTreeNode::subTreeByNodeID($params, $rootNode);
$cli->output("There are ". count($nodes). " nodes");
if (count($nodes)) {
    foreach ($nodes as $key => $node) {
        $url = $node->urlAlias();
        $cli->output("Working on this content ". $url);
        if (eZDashBoard::fetchByURL($url)) {
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
        $ezdash = eZDashBoard::create($attributeData);
        $ezdash->store();

        // @todo these rows are not standard
        if (isset($datamap['authors'])  && $datamap['authors']->hasContent()) {
            $author = $datamap['authors']->content();
            $authorID = "";
            if (count($author['relation_list'])) {
                foreach ($author['relation_list'] as $key => $author) {
                    $objectAuthor = eZContentObject::fetch($author['contentobject_id']);
                    $authorName   = trim(str_replace("  ", " ", $objectAuthor->attribute('name')));
                    $ezdashauthor = eZDashBoardAuthor::fetchByName($authorName);
                    if (!$ezdashauthor) {
                        $ezdashauthor = eZDashBoardAuthor::create($authorName);
                        $ezdashauthor->store();
                    }
                    $ezdash->linkedToAuthor($ezdashauthor->attribute('id'));
                }
            }
        }
        $db->commit();
        $cli->output("Done \n");
    }
}

$script->shutdown();
