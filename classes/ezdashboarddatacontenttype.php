<?php
/**
 * File containing the {@link eZDashBoardDataContentType} class
 *
 * @license GNU General Public License v2.0
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */
class eZDashBoardDataContentType
{
    public $typeInstance = false;
    /**
     * [__construct description]
     * @param string $contentType [description]
     */
    public function __construct($contentType)
    {
        $dashboardIni = eZINI::instance('dashboard.ini');
        if ($dashboardIni->hasVariable('DashBoardSettings', 'ClassContentType')) {
            $classContentType = $dashboardIni->variable('DashBoardSettings', 'ClassContentType');
            $this->typeInstance = new $classContentType[$contentType];
        }
    }
}
