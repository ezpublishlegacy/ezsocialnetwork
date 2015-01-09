<?php
/**
 * @licence http://www.gnu.org/licenses/gpl-2.0.txt GNU GPLv2
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */

$tpl = eZTemplate::factory();

$Result = array();
$Result['navigation_part'] = 'ezsocialnetworknavigationpart';
// $Result['content'] = $tpl->fetch( 'design:dashboard/dashboard.tpl' );
$Result['path'] = array( array( 'text' => ezpI18n::tr('ezdashboard', 'Dashboard'),
                                'url' => false ) );
$contentInfoArray['persistent_variable'] = false;
if ($tpl->variable('persistent_variable') !== false) {
    $contentInfoArray['persistent_variable'] = $tpl->variable('persistent_variable');
}

$Result['content_info'] = $contentInfoArray;
$Result['pagelayout'] = "extjs_pagelayout.tpl";
