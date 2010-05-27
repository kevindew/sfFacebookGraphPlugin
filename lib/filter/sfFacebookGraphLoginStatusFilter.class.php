<?php
/** 
 * Filter to process whether a user is logged in with facebook
 * 
 * @package     sfFacebookGraphPlugin
 * @subpackage  loginStatus
 * @author      Kevin Dew <kev@dewsolutions.co.uk>
 */
class sfFacebookGraphLoginStatusFilter extends sfFilter
{
  /**
   * Executes the filter chain.
   *
   * @param sfFilterChain $filterChain
   */
  public function execute($filterChain)
  {
    $facebookUid = sfFacebookGraph::getCurrentUser();
    $user = $this->context->getUser();

    // check for logged in user
    if ($facebookUid && !$user->isFacebookConnected()) {
      sfFacebookGraphUserProfile::getCurrentFacebookUser($user);
    }

    // check for logged out
    if ($user->isFacebookAuthenticated()
      && !$user->isFacebookConnected()) {
      $user->signOut();
    }

    $filterChain->execute();
  }
}


