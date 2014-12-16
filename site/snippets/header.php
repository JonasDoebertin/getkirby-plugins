<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= $site->title() ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- check js support -->
        <script>
            document.documentElement.className = document.documentElement.className.replace('no-js', 'js');
        </script>

        <!--<link rel="apple-touch-icon" href="apple-touch-icon.png">-->
        <!-- Place favicon.ico in the root directory -->

        <?= css('//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600') ?>
        <link rel="stylesheet" href="assets/css/main.@@1418765964987.css">

        <meta name="google-site-verification" content="<?= $site->googleverification() ?>">
    </head>
    <body class="template--<?= $page->intendedTemplate() ?>">

        <header class="section  section--header  header">
            <div class="section__wrap">

                <div class="header__logo">
                    <img class="logo" src="assets/images/logo.png" width="65" height="65" alt="Plugins &amp; Extensions for Kirby 2">
                </div>

                <h1 class="header__title"><?= $site->title() ?></h1>

        </div>
        </header>
