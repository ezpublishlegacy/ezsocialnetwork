<?php
/**
 * @license GNU General Public License v2.0
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */

require 'autoload.php';

$cli = eZCLI::instance();
$script = eZScript::instance(array( 'description' => ("eZ Publish Dashboard initialize data\n"),
                                     'use-session' => false,
                                     'use-modules' => true,
                                     'use-extensions' => true,
                                     'user' => true ));

$script->startup();

$script->initialize();

$dashboardIni = eZINI::instance('dashboard.ini');
if (!($dashboardIni->hasVariable('DashBoardSettings', 'WebSite'))) {
    $cli->error("You should add a WebSite in dashboard.ini");
    $script->shutdown(1);
}
$websites = $dashboardIni->variable('DashBoardSettings', 'WebSite');

$cli->output("Going to create row in dashboard_site\n");

foreach ($websites as $website) {
    if (!empty($website) && !eZDashBoardSite::fetchByName($website)) {
        $ezdash = eZDashBoardSite::create($website);
        $ezdash->store();
        $cli->output("$website is created\n");
    } else {
        $cli->error("not created\n");
    }
}

$script->shutdown();
