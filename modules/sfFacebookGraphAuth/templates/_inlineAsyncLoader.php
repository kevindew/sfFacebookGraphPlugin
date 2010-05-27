<?php
/**
 * Facebook loading script
 */
?>
<div id="fb-root"></div>
<?php javascript_tag(); ?>
  window.fbAsyncInit = function() {
    <?php include_partial('sfFacebookGraphAuth/inlineLoaderLogin', array(
      'signInUrl' => $signInUrl,
      'noSessionUrl' => $noSessionUrl,
      'redirectOnNoSession' => $redirectOnNoSession,
      'apiKey' => $apiKey,
      'jsStatus' => $jsStatus,
      'jsCookie' => $jsCookie,
      'jsXfbml' => $jsXfbml
    )) ?>
  };
  (function() {
    var e = document.createElement('script');
    e.async = true;
    e.src = document.location.protocol +
      '//connect.facebook.net/<?php echo $locale ?>/all.js';
    document.getElementById('fb-root').appendChild(e);
  }());
<?php end_javascript_tag();
