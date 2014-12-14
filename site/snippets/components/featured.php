
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

                <li class="layout__item  one-whole  lap-and-up-one-half">
                    <?php snippet('objects/plugin', ['plugin' => $plugin]) ?>
                <!--</li>-->

            <?php endforeach ?>

        </ul>
    </div>
</section>
