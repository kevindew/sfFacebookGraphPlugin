<?php

/**
 * Base authentication actions
 *
 * Based heavily on the work of Fabrice Bernhard et al on sfFacebookConnect
 *
 * @package     sfFacebookGraphPlugin
 * @subpackage  Authentication Module
 * @author      Kevin Dew <kev@dewsolutions.co.uk>
 */
class BasesfFacebookGraphAuthActions extends sfActions
{
  /**
   * Handle a Facebook signin. Try set up user.
   *
   * @param   sfRequest $request
   * @return  void
   */
  public function executeSignin($request)
  {
    $user = $this->getUser();

    try {

      sfFacebookGraphUserProfile::getCurrentFacebookUser($user);

    } catch (Exception $e) {

      if (sfConfig::get('sf_logging_enabled')) {
        sfContext
          ::getInstance()
          ->getLogger()
          ->info('{sfFacebookGraph} Error logging in ' . $e->getMessage());
      }

      $this->_redirectError($request, $user);
    }

    $this->_redirectSuccess($request, $user);

  }

  /**
   * Redirect process for a successful login
   *
   * @param   sfRequest $request
   * @param   sfUser    $user
   * @return  void
   */
  protected function _redirectSuccess($request, $user)
  {
    $signinUrl = sfConfig::get(
      'app_facebook_success_signin_url',
      $user->getReferer($request->getReferer())
    );

    $this->redirect('' != $signinUrl ? $signinUrl : '@homepage');
  }

  /**
   * Redirect process for a failed login
   *
   * @param   sfRequest $request
   * @param   sfUser    $user
   * @return  mixed
   */
  protected function _redirectError($request, $user)
  {
    if ($request->isXmlHttpRequest())
    {
      $this->getResponse()->setHeaderOnly(true);
      $this->getResponse()->setStatusCode(401);

      return sfView::NONE;
    }

    // if we have been forwarded, then the referer is the current URL
    // if not, this is the referer of the current request
    $user->setReferer($this->getContext()->getActionStack()->getSize() > 1
      ? $request->getUri()
      : $request->getReferer()
    );
    
    $this->redirect(
      sfConfig::get('sf_login_module') .'/'.sfConfig::get('sf_login_action')
    );
    
  }
}
