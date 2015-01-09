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
        $socialnetworkIni = eZINI::instance('socialnetwork.ini');
        if ($socialnetworkIni->hasVariable('SocialNetworkSettings', 'ClassContentType')) {
            $classContentType = $socialnetworkIni->variable('SocialNetworkSettings', 'ClassContentType');
            $this->typeInstance = new $classContentType[$contentType];
        }
    }
}
