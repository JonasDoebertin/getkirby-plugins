
<section class="section  section--plugins  plugins">
    <div class="section__wrap">
        <ul class="layout  js-isotope">

            <?php
                $plugins = $pages
                    ->find('plugins')->children()
                    ->filterBy('draft', 'false')
                    ->sortBy('uid', 'asc')
            ?>

            <?php foreach($plugins as $plugin): ?>

                <li class="[ layout__item  one-whole  lap-and-up-one-half  desk-one-third ] [ js-isotope-item <?= CssClasses::pluginType($plugin) ?> ]">
                    <?php snippet('objects/plugin', ['plugin' => $plugin]) ?>
                <!--</li>-->

            <?php endforeach ?>

            <li class="[ layout__item  one-whole  lap-and-up-one-half  desk-one-third ] [ js-isotope-item ]">
                <?php snippet('objects/themes') ?>
            <!--</li>-->

        </ul>
    </div>
</section>
