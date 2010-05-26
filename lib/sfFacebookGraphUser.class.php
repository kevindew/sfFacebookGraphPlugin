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
   * Gets the facebook user id of the logged in user
   *
   * @return int|null   A very large int probably
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

  /**
   * Checks whether a user is currently connected to facebook
   *
   * @return bool
   */
  public function isFacebookConnected()
  {

    return !is_null($this->getCurrentFacebookUid());
  }

  /**
   * Gets information about the user
   *
   * @param array $fields
   * @return array
   */
  public function getFacebookInfo()
  {
    $facebookUid = $this->getCurrentFacebookUid();

    $userInfo = null;

    if ($facebookUid) {
      try {
        $userInfo = sfFacebookGraph::getCurrentUserInfo();

      } catch (Exception $e) {}
    }

    return $userInfo;
  }
}