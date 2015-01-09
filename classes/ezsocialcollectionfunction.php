<?php

/**
 * @license GNU General Public License v2.0
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */
class eZSocialCollectionFunction
{
    public static function fetchByURL($url)
    {
        $result = array( 'result' => eZSocialNetwork::fetchByURL($url) );
        return $result;
    }
}
