<?php
/**
 * Facebook loading script
 */
?>
<div id="fb-root"></div>
<?php include_facebook_javascripts($locale) ?>
<?php javascript_tag(); ?>
    <?php include_partial('sfFacebookGraphAuth/inlineLoaderLogin', array(
      'signInUrl' => $signInUrl,
      'noSessionUrl' => $noSessionUrl,
      'redirectOnNoSession' => $redirectOnNoSession,
      'apiKey' => $apiKey,
      'jsStatus' => $jsStatus,
      'jsCookie' => $jsCookie,
      'jsXfbml' => $jsXfbml
    )) ?>
<?php end_javascript_tag();
