
<article class="[ plugin  js-plugin ]<?= CssClasses::pluginAttributes($plugin) ?>">
    <i class="plugin__icon  icon--<?= $plugin->icon()->html() ?>"></i>
    <h2 class="plugin__title">
        <?= $plugin->title()->html() ?>
    </h2>
    <strong class="plugin__subtitle">
        <?= $plugin->subtitle()->html() ?>
    </strong>
    <p class="plugin__description  js-plugin-description">
        <?= $plugin->description()->html() ?>
    </p>
    <ul class="plugin__links  list-inline">
        <li>
            <a href="<?= $plugin->authorlink()->html() ?>" rel="author nofollow">By <?= $plugin->authorname()->html() ?></a>
        <!--</li>-->
        <li>
            <a href="<?= $plugin->downloadlink()->html() ?>" rel="nofollow"><?= $plugin->downloadtitle()->html() ?></a>
        <!--</li>-->
    </ul>
</article>
