<?php
/**
 * Facebook loading script
 */
?>
<div id="fb-root"></div>
<?php include_facebook_javascripts($locale) ?>
<?php javascript_tag(); ?>
  FB.init({
    appId: '<?php echo $apiKey ?>',
    status: <?php echo ($jsStatus ? 'true' : 'false') ?>,
    cookie: <?php echo ($jsCookie ? 'true' : 'false') ?>,
    xfbml: <?php echo ($jsXfbml ? 'true' : 'false') ?>
  });
<?php end_javascript_tag();
