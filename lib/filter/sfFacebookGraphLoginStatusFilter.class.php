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
    $facebookUser = sfFacebookGraph::getCurrentUser();

    if ($facebookUser && !$this->context->getUser()->isFacebookConnected()) {
      sfFacebookGraphUserProfile::getCurrentFacebookUser(
        $this->context->getUser()
      );
    }

    $filterChain->execute();
  }
}


