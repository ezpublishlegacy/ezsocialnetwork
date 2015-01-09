<?php
/**
 * File containing the {@link eZSocialNetworkDataContentType} class
 *
 * @license GNU General Public License v2.0
 * @author Dany Ralantonisainana <lendormi1984@gmail.com>
 */
class eZSocialNetworkDataContentType
{
    public $typeInstance = false;
    /**
     * [__construct description]
     * @param string $contentType [description]
     */
    public function __construct($contentType)
    {
        $dashboardIni = eZINI::instance('socialnetwork.ini');
        if ($dashboardIni->hasVariable('SocialNetworkSettings', 'ClassContentType')) {
            $classContentType = $dashboardIni->variable('SocialNetworkSettings', 'ClassContentType');
            $this->typeInstance = new $classContentType[$contentType];
        }
    }
}
