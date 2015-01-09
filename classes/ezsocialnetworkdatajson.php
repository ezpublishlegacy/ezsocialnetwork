<?php
/**
 * File containing the {@link eZSocialNetworkJson} class
 *
 * @license GNU General Public License v2.0
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */
class eZSocialNetworkDataJson
{
    public function __construct()
    {
    }

    /**
     * get list content
     * @param  string $type [description]
     * @return array        data
     */
    public function getContent($type)
    {
        switch ($type) {
            case 'content':
                return eZSocialNetwork::fetchList();
                break;
            case 'site':
                return eZSocialNetworkSite::fetchList();
                break;
            default:
                # code...
                break;
        }
    }
}
