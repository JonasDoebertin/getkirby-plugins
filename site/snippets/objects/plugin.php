
<article>
    <a class="[ plugin js-plugin ]<?= CssClasses::pluginAttributes($plugin) ?>" href="<?= url($plugin->uid()) ?>">
        <span class="plugin__icon">
            <i class="icon--<?= $plugin->icon()->html() ?>"></i>
        </span>
        <h2 class="plugin__title">
            <?= $plugin->title()->html() ?>
        </h2>
        <strong class="plugin__subtitle">
            <?= $plugin->subtitle()->html() ?>
        </strong>
        <p class="plugin__author">
            By <?= $plugin->authorname()->html() ?>
        </p>
        <p class="plugin__description  js-plugin-description">
            <?= $plugin->description()->html() ?>
        </p>
        <p class="plugin__link link">
            More Info
        </p>
    </a>
</article>
