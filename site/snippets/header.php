<!doctype html>
<html class="no-js" lang="en">
    <head>

        <!-- meta -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= $site->title()->html() ?></title>
        <meta name="description" content="<?= $site->description()->html() ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- check js support -->
        <script>
            document.documentElement.className = document.documentElement.className.replace('no-js', 'js');
        </script>

        <!-- set global javascript configuration -->
        <script>
            var Config = {
                'environment': '<?= Environment::get() ?>'
            }
        </script>

        <!-- styles -->
        <?= css('//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600|Source+Code+Pro:500') ?>
        <?= css('/assets/css/main.@@1435215350902.css') ?>

        <!-- favicons -->
        <link rel="apple-touch-icon" sizes="57x57" href="<?= url('/assets/images/favicons/apple-touch-icon-57x57.png') ?>">
        <link rel="apple-touch-icon" sizes="114x114" href="<?= url('/assets/images/favicons/apple-touch-icon-114x114.png') ?>">
        <link rel="apple-touch-icon" sizes="72x72" href="<?= url('/assets/images/favicons/apple-touch-icon-72x72.png') ?>">
        <link rel="apple-touch-icon" sizes="144x144" href="<?= url('/assets/images/favicons/apple-touch-icon-144x144.png') ?>">
        <link rel="apple-touch-icon" sizes="60x60" href="<?= url('/assets/images/favicons/apple-touch-icon-60x60.png') ?>">
        <link rel="apple-touch-icon" sizes="120x120" href="<?= url('/assets/images/favicons/apple-touch-icon-120x120.png') ?>">
        <link rel="apple-touch-icon" sizes="76x76" href="<?= url('/assets/images/favicons/apple-touch-icon-76x76.png') ?>">
        <link rel="apple-touch-icon" sizes="152x152" href="<?= url('/assets/images/favicons/apple-touch-icon-152x152.png') ?>">
        <link rel="apple-touch-icon" sizes="180x180" href="<?= url('/assets/images/favicons/apple-touch-icon-180x180.png') ?>">
        <meta name="apple-mobile-web-app-title" content="Kirby Plugins">
        <link rel="shortcut icon" href="<?= url('/assets/images/favicons/favicon.ico') ?>">
        <link rel="icon" type="image/png" href="<?= url('/assets/images/favicons/favicon-192x192.png') ?>" sizes="192x192">
        <link rel="icon" type="image/png" href="<?= url('/assets/images/favicons/favicon-160x160.png') ?>" sizes="160x160">
        <link rel="icon" type="image/png" href="<?= url('/assets/images/favicons/favicon-96x96.png') ?>" sizes="96x96">
        <link rel="icon" type="image/png" href="<?= url('/assets/images/favicons/favicon-16x16.png') ?>" sizes="16x16">
        <link rel="icon" type="image/png" href="<?= url('/assets/images/favicons/favicon-32x32.png') ?>" sizes="32x32">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="msapplication-TileImage" content="<?= url('/assets/images/favicons/mstile-144x144.png') ?>">
        <meta name="msapplication-config" content="<?= url('/assets/images/favicons/browserconfig.xml') ?>">
        <meta name="application-name" content="Kirby Plugins">

        <!-- misc -->
        <link rel="alternate" type="application/rss+xml" title="RSS" href="<?= url('feed') ?>" />
        <meta name="google-site-verification" content="<?= $site->googleverification() ?>" />

    </head>
    <body class="template--<?= $page->intendedTemplate() ?>">

        <header class="section  section--header  header">
            <div class="section__wrap">

                <div class="header__logo">
                    <a href="<?= $site->url() ?>" rel="index">
                        <img class="logo" src="<?= url('assets/images/logo.png') ?>" width="65" height="65" alt="Plugins &amp; Extensions for Kirby CMS">
                    </a>
                </div>

                <h1 class="header__title"><?= $site->heading()->html() ?></h1>

                <ul class="header__social  list-inline  social-nav">
                    <?php foreach(yaml($site->social()) as $network): ?>
                        <li class="social-nav__item">
                            <a href="<?= $network['link'] ?>" target="_blank"><i class="icon--<?= $network['icon'] ?>"></i></a>
                        <!--</li>-->
                    <?php endforeach ?>
                </ul>

        </div>
        </header>
