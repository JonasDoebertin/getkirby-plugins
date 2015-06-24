
<section class="section  section--featured  featured">
    <div class="section__wrap">
        <ul class="layout">

            <?php
                $plugins = $pages
                            ->find('plugins')->children()
                            ->filterBy('draft', 'false')
                            ->filterBy('featured', 'true')
                            ->sortBy('created', 'DESC')
                            ->limit(2)
            ?>
            <?php foreach($plugins as $plugin): ?>

                <li class="layout__item  one-whole  lap-and-up-one-half desk-two-fifths">
                    <?php snippet('objects/plugin', ['plugin' => $plugin]) ?>
                <!--</li>-->

            <?php endforeach ?>

            <li class="layout__item  one-whole  lap-and-up-one-whole desk-one-fifth">
                <?php snippet('objects/twitter') ?>
            <!--</li>-->

        </ul>
    </div>
</section>
