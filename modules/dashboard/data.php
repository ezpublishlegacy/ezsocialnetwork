<?php

/**
 * File containing children
 * Improvements for SEO
 *
 * @copyright Copyright (C) 2013 Mondadori France
 * @author Dany RALANTONISAINANA <Dany.Ralantonisainana@mondador.fr>
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2 (or any later version)
 * @version 1.0.0
 * @package grazia
 * @example :
 * 1. dashboard/data/debug?ContentType=html
 * Display debug for your children
 * 2. dashboard/data/?ContentType=json
 * Display json result
 */

$http        = eZHTTPTool::instance();
$module      = $Params['Module'];
$type        = $Params['Type'];
$debugOutput = isset($Params['debug']) ? $Params['debug'] : false;
$response    = array();

// Allow get parameter to be set to test in browser
if ($http->hasGetVariable('ContentType')) {
    $contentType = $http->getVariable('ContentType');
} else {
    $contentType = ezjscAjaxContent::getHttpAccept();
    header('Vary: Accept');
}

// if (!$nodeId || $nodeId<1) {
//     header( $_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error' );
//     $response = array( 'error_text' => 'param node_id manquant', 'content' => '' );
//     echo ezjscAjaxContent::autoEncode( $response, $contentType );
//     eZExecution::cleanExit();
// }

if ($contentType === 'json') {
    header('Content-Type: application/json; charset=utf-8');
} elseif ($contentType === 'html') {
    header('Content-Type: text/html; charset=utf-8');
} else {
    exit('no content type');
    eZExecution::cleanExit();
}

$children = array();
$response['content'] = "";
try {
    $bError = false;
    $jsonInstance = new eZSocialNetworkDataContentType($contentType);
    $jsonInstance->debug = $debugOutput;
    $response["content"] = $jsonInstance->typeInstance->getContent($type);
    if (!$response["content"]) {
        throw new Exception('Data don\'t load');
    }
} catch (Exception $e) {
    $response['error_text'] = $e->getMessage();
}
echo ezjscAjaxContent::autoEncode($response, $contentType);

if ($debugOutput) {
    echo "/*\r\n";
    eZDebug::printReport(false, true);
    echo "\r\n*/";
}

eZDB::checkTransactionCounter();
eZExecution::cleanExit();
