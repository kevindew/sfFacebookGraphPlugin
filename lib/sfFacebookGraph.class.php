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
   * @static  Facebook|null
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
        'secret' => self::getApiSecret(),
        'cookie' => true
      ));
    }

    return self::$_facebookPlatform;
  }
}
