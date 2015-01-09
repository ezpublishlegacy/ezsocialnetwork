<?php
/**
 * @license GNU General Public License v2.0
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */

require 'autoload.php';

$cli = eZCLI::instance();
$script = eZScript::instance(array( 'description' => ("eZ Publish SocialNetwork initialize data\n"),
                                     'use-session' => false,
                                     'use-modules' => true,
                                     'use-extensions' => true,
                                     'user' => true ));

$script->startup();

$script->initialize();

$socialnetworkIni = eZINI::instance('socialnetwork.ini');
if (!($socialnetworkIni->hasVariable('SocialNetworkSettings', 'WebSite'))) {
    $cli->error("You should add a WebSite in socialnetwork.ini");
    $script->shutdown(1);
}
$websites = $socialnetworkIni->variable('SocialNetworkSettings', 'WebSite');

$cli->output("Going to create row in socialnetwork_site\n");

foreach ($websites as $website) {
    if (!empty($website) && !eZSocialNetworkSite::fetchByName($website)) {
        $ezdash = eZSocialNetworkSite::create($website);
        $ezdash->store();
        $cli->output("$website is created\n");
    } else {
        $cli->error("not created\n");
    }
}

$script->shutdown();
