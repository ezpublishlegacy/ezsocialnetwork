<?php
/**
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://ez.no/Resources/Software/Licenses/eZ-Business-Use-License-Agreement-eZ-BUL-Version-2.1 eZ Business Use License Agreement eZ BUL Version 2.1
 * @version 4.7.0
 * @package kernel
 */

$FunctionList = array();
$FunctionList['data'] = array( 'name' => 'data',
                               'operation_types' => array( 'read' ),
                               'call_method' => array( 'class' => 'eZSocialCollectionFunction',
                                                       'method' => 'fetchByURL' ),
                               'parameter_type' => 'standard',
                               'parameters' => array( array( 'name' => 'url',
                                                             'type' => 'string',
                                                             'required' => true,
                                                             'default' => false ) ) );