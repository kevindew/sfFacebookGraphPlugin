<?php
/**
 * Facebook loading script
 */
?>
<div id="fb-root"></div>
<?php javascript_tag(); ?>
  if (typeof fbAsyncInit == 'undefined') {
    fbAsyncInit = new AsyncFunction();
  }
  fbAsyncInit.addMethod(function() {
    FB.init({
      appId: '<?php echo $apiKey ?>',
      status: <?php echo ($jsStatus ? 'true' : 'false') ?>,
      cookie: <?php echo ($jsCookie ? 'true' : 'false') ?>,
      xfbml: <?php echo ($jsXfbml ? 'true' : 'false') ?>
    });
  }, true);
  (function() {
    var e = document.createElement('script');
    e.async = true;
    e.src = document.location.protocol +
      '//connect.facebook.net/<?php echo $locale ?>/all.js';
    document.getElementById('fb-root').appendChild(e);
  }());
<?php end_javascript_tag();
