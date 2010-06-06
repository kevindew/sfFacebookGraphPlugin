<?php
/**
 * Helper functions for sfFacebookGraph
 */

/**
 * Get the Facebook XMLNS
 *
 * @return string
 */
function get_facebook_xmlns()
{
  return 'xmlns:fb="http://www.facebook.com/2008/fbml"';
}

/**
 * @see get_facebook_xmlns
 */
function include_facebook_xmlns()
{
  echo get_facebook_xmlns();
}

/**
 * Get an array of javascripts to include for Facebook
 *
 * @param   string|null  $locale  (Optional) A formatted lanaguage string for
 *                                Facebook e.g. en_US. Default null.
 * @return  array
 */
function get_facebook_javascripts($locale = null)
{
  if ($locale === null) {
    $locale = sfConfig::get('app_facebook_default_locale', 'en_US');
  }

  return array(
    "http://connect.facebook.net/$locale/all.js"
  );
}

/**
 * Output the HTML for included Facebook javascript
 *
 * @param   string|null  $locale  (Optional) A formatted lanaguage string for
 *                                Facebook e.g. en_US. Default null.
 * @return  void
 */
function include_facebook_javascripts($locale = null)
{
  foreach (get_facebook_javascripts($locale) as $script) {
    echo javascript_include_tag($script) . PHP_EOL;
  }
}

/**
 * Output a permissions string, taken normally from the app config
 *
 * @param   string|null  $perms (Optional) A string of Facebook permissions e.g.
 *                              offline_access,user_photos . Default null.
 * @return string
 */
function get_facebook_permissions($perms = null)
{
  if ($perms === null) {
    $perms = sfConfig::get('app_facebook_base_perms', '');
  }

  if ($perms) {
    return ' perms="' . $perms . '"';
  }
  
  return '';
}

/**
 * @see get_facebook_permissions
 */
function include_facebook_permissions($perms = null)
{
  echo get_facebook_permissions($perms);
}

/**
 * Include an asynchronous facebook loader. Publish assets must be loaded to use
 * this.
 *
 * @param   array $options
 * @return  void
 */
function include_facebook_inline_async_loader(
  $locale = null,
  $partial = 'sfFacebookGraphAuth/inlineAsyncLoader'
)
{

  if ($locale === null) {
    $locale = sfConfig::get('app_facebook_default_locale', 'en_US');
  }

  include_partial(
    $partial,
    array(
      'locale' => $locale,
      'apiKey' => sfConfig::get('app_facebook_api_key'),
      'jsStatus' => sfConfig::get('app_facebook_js_status', true),
      'jsCookie' => sfConfig::get('app_facebook_app_cookie', true),
      'jsXfbml' => sfConfig::get('app_facebook_js_xfbml', true)
    )
  );
}

/**
 * Include an synchronous facebook loader. (poorer performance than asyncronous
 * but simpler to code for)
 *
 * @param   array $options
 * @return  void
 */
function include_facebook_inline_loader(
  $locale = null,
  $partial = 'sfFacebookGraphAuth/inlineLoader'
)
{
  if ($locale === null) {
    $locale = sfConfig::get('app_facebook_default_locale', 'en_US');
  }

  include_partial(
    $partial,
    array(
      'locale' => $locale,
      'apiKey' => sfConfig::get('app_facebook_api_key'),
      'jsStatus' => sfConfig::get('app_facebook_js_status', true),
      'jsCookie' => sfConfig::get('app_facebook_app_cookie', true),
      'jsXfbml' => sfConfig::get('app_facebook_js_xfbml', true)
    )
  );
}

/**
 *
 * @param array $options  These can be
 *                        * signInUrlu
 */
function include_facebook_login_javascript(array $options = array())
{
  $defaultOptions = array(
    'signInUrl' => null,
    'noSessionUrl' => null,
    'redirectOnNoSession' => null,
    'includeJavascriptTags' => true,
    'partial' => 'sfFacebookGraphAuth/inlineLogin'
  );

  $options = array_merge($defaultOptions, $options);

  if ($options['signInUrl'] === null) {
    $options['signInUrl'] = sfConfig::get(
      'app_facebook_connect_signin_url',
      'sfFacebookGraphAuth/signin'
    );
  }

  if ($options['noSessionUrl'] === null) {
    $options['noSessionUrl'] = sfConfig::get(
      'app_facebook_no_session_redirect_url',
      null
    );
  }

  if ($options['redirectOnNoSession'] === null) {
    $options['redirectOnNoSession'] = sfConfig::get(
      'app_facebook_redirect_on_no_session',
      true
    );
  }

  if ($options['includeJavascriptTags']) {
    javascript_tag();
  }

  include_partial(
    $options['partial'],
    array(
      'signInUrl' => $options['signInUrl'],
      'noSessionUrl' => $options['noSessionUrl'],
      'redirectOnNoSession' => $options['redirectOnNoSession']
    )
  );

  if ($options['includeJavascriptTags']) {
    end_javascript_tag();
  }
}