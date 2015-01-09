<?php
/**
 * @license GNU General Public License v2.0
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */

$cli->output("Prepare to update all data social network on this eZ Publish...");

$socialNetworkINI = eZINI::instance('socialnetwork.ini');
$ezdashs = eZSocialNetwork::fetchListByTime('-1 month');
if ($ezdashs) {
    foreach ($ezdashs as $key => $ezdashID) {
        $ezdashboard = eZSocialNetwork::fetch($ezdashID);
        $url = $ezdashboard->getURL();
        $cli->output("Working on this content ". $url);
        $dataSocial = SocialRequest::requestAllSocialNetwork($url, 'statsUrl');
        if (count($dataSocial) > 0) {
            foreach ($dataSocial as $attribute => $data) {
                $ezdashboard->setAttribute($attribute, $data);
            }
        }
        
        if ($socialNetworkINI->hasVariable('SocialNetworkSettings', 'eZPublishHandler')) {
            $ezHandler = $socialNetworkINI->variable('SocialNetworkSettings', 'eZPublishHandler');
            $ezdashboard->setAttribute('ezpublish', $ezHandler::statsUrl($ezdashboard->attribute('url')));
        }
        $ezdashboard->setAttribute('date_modified', time());
        $ezdashboard->store();
        // User Rate Limit Exceeded hack
        sleep($socialNetworkINI->variable('SocialNetworkSettings', 'UserRateLimit'));
    }
}
$cli->output("All data updated !!!");
