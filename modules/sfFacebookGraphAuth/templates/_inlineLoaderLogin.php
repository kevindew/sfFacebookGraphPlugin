<?php
/**
 * Facebook login handling
 */
?>
<?php if ($redirectOnNoSession) : ?>
FB.Event.subscribe('auth.sessionChange', function(response) {
  if (response.session) {
    <?php if ($signInUrl) : ?>
    window.location = '<?php echo $signInUrl ?>';
    <?php else : ?>
    document.location.reload();
    <?php endif; ?>
  } else {
    <?php if ($noSessionUrl) : ?>
    window.location = '<?php echo $noSessionUrl ?>';
    <?php else : ?>
    document.location.reload();
    <?php endif; ?>
  }
});
<?php else : ?>
FB.Event.subscribe('auth.login', function(response) {
  <?php if ($signInUrl) : ?>
  window.location = '<?php echo $signInUrl ?>';
  <?php else : ?>
  document.location.reload();
  <?php endif; ?>
});
<?php endif; ?>