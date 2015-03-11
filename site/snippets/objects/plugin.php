
<article class="[ plugin  js-plugin ]<?= CssClasses::pluginAttributes($plugin) ?>">
    <a class="plugin__icon" href="<?= $plugin->downloadlink()->html() ?>" rel="nofollow">
        <i class="icon--<?= $plugin->icon()->html() ?>"></i>
    </a>
    <h2 class="plugin__title">
        <a href="<?= $plugin->downloadlink()->html() ?>" rel="nofollow">
            <?= $plugin->title()->html() ?>
        </a>
    </h2>
    <strong class="plugin__subtitle">
        <?= $plugin->subtitle()->html() ?>
    </strong>
    <p class="plugin__author">
        <a href="<?= $plugin->authorlink()->html() ?>" rel="author nofollow">
            By <?= $plugin->authorname()->html() ?>
        </a>
    </p>
    <p class="plugin__description  js-plugin-description">
        <?= $plugin->description()->html() ?>
    </p>

    <p class="plugin__link">
        <a href="<?= $plugin->downloadlink()->html() ?>" rel="nofollow">
            Documentation
        </a>
    </p>
</article>
