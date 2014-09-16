<?php
/**
 * @licence http://www.gnu.org/licenses/gpl-2.0.txt GNU GPLv2
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */

$Module = array( 'name' => 'eZ Dashboard' );

$ViewList = array();

$ViewList[''] = array( 'functions' => array( 'admin' ),
                       'script' => 'index.php'
);

$FunctionList = array();
$FunctionList['admin'] = array();
