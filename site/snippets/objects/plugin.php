
<article class="plugin <?= pluginclasses($plugin) ?>">
    <i class="plugin__icon  icon--generic"></i>
    <h2 class="plugin__title"><?= $plugin->title()->html() ?></h2>
    <strong class="plugin__subtitle"><?= $plugin->subtitle()->html() ?></strong>
    <p class="plugin__description  js-plugin-description"><?= $plugin->description()->html() ?></p>
    <ul class="plugin__links  list-inline">
        <li>
            <a href="<?= $plugin->authorlink()->html() ?>" rel="author">By <?= $plugin->authorname()->html() ?></a>
        <!--</li>-->
        <li>
            <a href="<?= $plugin->downloadlink()->html() ?>"><?= $plugin->downloadtitle()->html() ?></a>
        <!--</li>-->
    </ul>
</article>
