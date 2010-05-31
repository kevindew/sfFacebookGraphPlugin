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
   * Method to determine whether a user was authenticated with facebook or not
   *
   * @return bool
   */
  public function isFacebookAuthenticated($default = null)
  {
    if ($default === null) {

      $user = $this->getGuardUser();

      // we'll guess the default off whether they have a facebook uid in their
      // profile
      $default = $user ? (bool) $user->getProfile()->getFacebookUid() : false;
    }

    return $this->getAttribute(
      'facebook_authenticated',
      $default,
      'sfGuardSecurityUser'
    );
  }

  /**
   * Set whether a user was facebook authenticated or not
   *
   * @param   bool  $facebookAuthenticated
   * @return  self
   */
  public function setFacebookAuthenticated($facebookAuthenticated)
  {
    // Using the sfGuardSecurityUser so that it can be removed when thats logged
    // out
    $this->setAttribute(
      'facebook_authenticated',
      $facebookAuthenticated,
      'sfGuardSecurityUser'
    );

    return $this;
  }

  public function signIn(
    $user, $remember = false, $con = null, $facebookAuthenticated = false
  )
  {
    $this->setFacebookAuthenticated($facebookAuthenticated);
    return parent::signIn($user, $remember, $con);
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