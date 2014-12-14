
<section class="section  section--addplugin  addplugin">
    <div class="section__wrap">
        <h2 class="addplugin__title"><?= $page->addpluginheading()->html() ?></h2>
        <p class="addplugin__description"><?= $page->addpluginlead()->html() ?></p>
        <a class="addplugin__button" href="<?= $page->addpluginlink()->html() ?>" target="_blank"><?= $page->addpluginbutton()->html() ?></a>
    </div>
</section>
