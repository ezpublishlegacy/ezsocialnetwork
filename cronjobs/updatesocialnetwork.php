<?php
/**
 * @license GNU General Public License v2.0
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */

$cli->output("Prepare to update all data social network on this eZ Publish...");
$db = eZDB::instance();
$socialNetworkINI = eZINI::instance('socialnetwork.ini');
// disabled binary log on this session mysqli
if ($socialNetworkINI->hasVariable('SocialNetworkSettings', 'BinaryLog') &&
    $socialNetworkINI->variable('SocialNetworkSettings', 'BinaryLog') == "enabled") {
    $db->query("set sql_log_bin = 0;");
}
$ezdashs = eZSocialNetwork::fetchListByTime('-1 month');
if ($ezdashs) {
    foreach ($ezdashs as $key => $ezdashID) {
        $ezsocialnetwork = eZSocialNetwork::fetch($ezdashID);
        $url = $ezsocialnetwork->getURL();
        $cli->output("Working on this content ". $url);
        $dataSocial = SocialRequest::requestAllSocialNetwork($url, 'statsUrl');
        if (count($dataSocial) > 0) {
            foreach ($dataSocial as $attribute => $data) {
                $ezsocialnetwork->setAttribute($attribute, $data);
            }
        }
        
        if ($socialNetworkINI->hasVariable('SocialNetworkSettings', 'eZPublishHandler')) {
            $ezHandler = $socialNetworkINI->variable('SocialNetworkSettings', 'eZPublishHandler');
            $ezsocialnetwork->setAttribute('ezpublish', $ezHandler::statsUrl($ezsocialnetwork->attribute('url')));
        }
        $ezsocialnetwork->setAttribute('date_modified', time());
        $ezsocialnetwork->store();
        // User Rate Limit Exceeded hack
        sleep($socialNetworkINI->variable('SocialNetworkSettings', 'UserRateLimit'));
    }
}
$cli->output("All data updated !!!");
