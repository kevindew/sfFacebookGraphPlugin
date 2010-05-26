<?php
/**
 * A class to ease communication with the Facebook Graph API
 *
 * Based heavily on the work of Fabrice Bernhard et al on sfFacebookConnectPlugin
 *
 * @package   sfFacebookGraphPlugin
 * @author    Kevin Dew <kev@dewsolutions.co.uk>
 */

class sfFacebookGraph
{

  /**
   * The facebook platform object
   * @var  Facebook|null
   */
  static protected $_facebookPlatform = null;

  /**
   * The applications API key hash
   *
   * @return string
   */
  static public function getApiKey()
  {
    return sfConfig::get('app_facebook_api_key');
  }

  /**
   * The application secret
   *
   * @return string
   */
  static public function getAppSecret()
  {
    return sfConfig::get('app_facebook_app_secret');
  }

  /**
   * The id of the application
   *
   * @return int
   */
  static public function getAppId()
  {
    return sfConfig::get('app_facebook_app_key', false);
  }

  /**
   * Whether to enable cookie support
   *
   * @return string|null
   */
  static public function getAppCookie()
  {
    return sfConfig::get('app_facebook_app_cookie', true);
  }

  /**
   * Get the cookie domain to use for cookies
   *
   * @return string|null
   */
  static public function getAppCookieDomain()
  {
    return sfConfig::get('app_facebook_app_cookie_domain', null);
  }

  /**
   * Get an instance of the Facebook object for API calls
   * 
   * @return Facebook
   */
  static public function getFacebookPlatform()
  {
    if (self::$_facebookPlatform === null)
    {
      // using different facebook sdk

      self::$_facebookPlatform = new Facebook(array(
        'appId'  => self::getApiKey(),
        'secret' => self::getAppSecret(),
        'cookie' => true
      ));
    }

    return self::$_facebookPlatform;
  }

  /**
   * Get the current Facebook user id
   *
   * @return  int|null
   */
  static public function getCurrentUser()
  {
    return self::getFacebookPlatform()->getUser();
  }

  /**
   * Get current access token
   *
   * @return  string|null
   */
  static public function getCurrentAccessToken()
  {
    $session = self::getFacebookPlatform()->getSession();

    if (isset($session['access_token'])) {
      return $session['access_token'];
    }

    return null;
  }

  /**
   * Get current access expiry timestamp
   *
   * @return  int|null
   */
  static public function getCurrentAccessExpiry()
  {
    $session = self::getFacebookPlatform()->getSession();

    if (isset($session['expires'])) {
      return (int) $session['expires'];
    }

    return null;
  }

  /**
   * Gets the user information (available to this app) for the currently logged
   * in facebook user
   *
   * @throws  facebookApiException
   * @return  array
   */
  static public function getCurrentUserInfo()
  {
    return self::getFacebookPlatform()->api('/me');
  }

  /**
   * Check an email address to see if it's facebook proxymail account
   * 
   * @param   string  $email
   * @return  bool
   */
  static public function checkProxyEmail($email)
  {
    return preg_match('/(.*)@proxymail.facebook.com/i', $email);
  }
}
