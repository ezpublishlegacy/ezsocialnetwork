<?php
/**
 * File containing the {@link eZDashBoardJson} class
 *
 * @license GNU General Public License v2.0
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */
class eZDashBoardDataJson
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
                return eZDashBoard::fetchList();
                break;
            case 'site':
                return eZDashBoardSite::fetchList();
                break;
            default:
                # code...
                break;
        }
    }
}
