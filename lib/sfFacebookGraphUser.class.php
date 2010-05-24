<?php
/**
 * A user class for managing users that could either be regular users
 * or facebook users
 *
 * Based heavily on the work of Fabrice Bernhard et al on sfFacebookConnectPlugin
 *
 * @package     sfFacebookGraphPlugin
 * @subpackage  user
 * @author      Kevin Dew <kev@dewsolutions.co.uk>
 */

class sfFacebookGraphUser extends sfGuardSecurityUser
{
  /**
   *
   * @return integer
   * @author fabriceb
   * @since May 27, 2009 fabriceb
   */
  public function getCurrentFacebookUid()
  {
    $sfGuardUser = $this->getGuardUser();

    $facebookUid = sfFacebookGraph::getFacebookPlatform()
                                  ->getUser();
    
    
    if ($sfGuardUser
     && $facebookUid == $sfGuardUser->getProfile()->getFacebookUid()
    ) {
      return $facebookUid;
    }

    return null;
  }

  public function isFacebookConnected()
  {

    return !is_null($this->getCurrentFacebookUid());
  }

//  /**
//   * Gets information about the user
//   *
//   * @param array $fields
//   * @return array
//   */
//  public function getInfos($fields)
//  {
//    $userInfo = sfFacebookGraph::getFacebookPlatform()
//                               ->users_getInfo(array($this->getCurrentFacebookUid()),$fields);
//
//    return reset($userInfos);
//  }
}