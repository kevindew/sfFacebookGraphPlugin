<?php
/**
 * Facebook inline loader login code
 */
?>
FB.init({appId: '<?php echo $apiKey ?>', status: <?php echo ($jsStatus ? 'true' : 'false') ?>,
  cookie: <?php echo ($jsCookie ? 'true' : 'false') ?>, xfbml: <?php echo ($jsXfbml ? 'true' : 'false') ?>});
<?php if ($redirectOnNoSession) : ?>
FB.Event.subscribe('auth.sessionChange', function(response) {
  if (response.session) {
    window.location = '<?php echo url_for($signInUrl) ?>';
  } else {
    <?php if ($noSessionUrl) : ?>
    window.location = '<?php echo url_for($noSessionUrl) ?>';
    <?php else : ?>
    document.location.reload();
    <?php endif; ?>
  }
});
<?php else : ?>
FB.Event.subscribe('auth.login', function(response) {
  window.location = '<?php echo url_for($signInUrl) ?>';
});
<?php endif; ?>