<?php use_helper('sfFacebookGraph') ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"
  <?php include_facebook_xmlns() ?>>
  <head>

    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php use_javascript('/sfFacebookGraphPlugin/js/asyncFunction.js') ?>
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
    <?php javascript_tag() ?>
      window.fbAsyncInit = new AsyncFunction();
      fbAsyncInit.addMethod(function () {
      <?php include_facebook_login_javascript(array('includeJavascriptTags' => false)) ?>
      });
    <?php end_javascript_tag() ?>
  </head>
  <body>
    <?php include_facebook_inline_async_loader() ?>
    <h1>Facebook Demo</h1>
    <?php if ($sf_user->isFacebookConnected()) : ?>
      Hi <?php echo $sf_user->getProfile()->getFullName() ?>.
      <fb:profile-pic uid="<?php echo $sf_user->getProfile()->getFacebookUid() ?>" size="s"></fb:profile-pic>
      <div>
        <a href="<?php echo $sf_user->getProfile()->getFacebookLogoutUrl() ?>">Logout</a>
      </div>
    <?php else : ?>
      You are not currently logged in
      <fb:login-button length="long"<?php include_facebook_permissions() ?>></fb:login-button>
    <?php endif; ?>
  </body>
</html>
