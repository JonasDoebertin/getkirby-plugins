
<section class="section  section--info  info">
    <div class="section__wrap">

        <ul class="layout">

            <li class="layout__item  one-whole  lap-and-up-two-thirds  desk-three-quarters">
                <article>
                    <h3 class="info__headline">
                        Additional Information
                    </h3>
                    <div class="info__description">

                        <?php if ($info = github()->info($page->repository())): ?>
                            <?= $info ?>
                        <?php elseif (!$page->text()->empty()): ?>
                            <?= $page->text()->kirbytext() ?>
                        <?php else: ?>
                            <p>
                                <?= $page->description()->html() ?>
                            </p>
                        <?php endif ?>
                    </div>
                    <div class="info__read-more">
                        <a href="<?= $page->website()->or($page->repository()) ?>" rel="help nofollow">Read the full documentation</a>
                    </div>
                </article>
            <!-- </li> -->
            <li class="layout__item  one-whole  lap-and-up-one-third  desk-one-quarter">
                <aside>
                    <h3 class="info__headline">
                        Plugin Meta
                    </h3>
                    <dl class="report__meta">
                        <dt class="info__meta__item  info__meta__item--inline">
                            Author
                        </dt>
                        <dd>
                            <a href="<?= $page->authorlink() ?>" rel="author nofollow">
                                <?= $page->authorname()->html() ?>
                            </a>
                        </dd>

                        <?php if (!$page->repository()->empty()): ?>
                            <dt class="info__meta__item  info__meta__item--inline">
                                Repo
                            </dt>
                            <dd>
                                <a href="<?= $page->repository() ?>" rel="nofollow">
                                    <?= Url::host($page->repository()) ?>
                                </a>
                            </dd>
                        <?php endif ?>

                        <?php if (!$page->website()->empty()): ?>
                            <dt class="info__meta__item  info__meta__item--inline">
                                Website
                            </dt>
                            <dd>
                                <a href="<?= $page->website() ?>" rel="nofollow">
                                    <?= Url::host($page->website()) ?>
                                </a>
                            </dd>
                        <?php endif ?>

                        <dt class="info__meta__item  info__meta__item--inline">
                            Version
                        </dt>
                        <dd>
                            <?php if ($version = github()->release($page->repository())): ?>
                                <?= $version ?>
                            <?php else: ?>
                                <em>Unknown</em>
                            <?php endif ?>
                        </dd>

                        <dt class="info__meta__item  info__meta__item--inline">Added</dt>
                        <dd><?= date('j M Y', strtotime($page->created())) ?></dd>

                        <dt class="info__meta__item  info__meta__item--block">Description</dt>
                        <dd>
                            <?= $page->description()->html() ?>
                        </dd>

                    </dl>

                    <p class="info__button">
                        <a href="<?= $page->website()->or($page->repository()) ?>" rel="help nofollow">
                            Full Documentation
                        </a>
                    </p>

                    <ul class="info__links">
                        <li>
                            <a href="<?= url('about/plugin-pages') ?>" rel="help">
                                About this Page
                            </a>
                        </li>
                        <li>
                            <a href="https://docs.google.com/forms/d/15ksJbVeFx6PhI1vuOdvdKQguRL8lNtQ9PA2N0G5v_E0/viewform?entry.372255256=http://getkirby-plugins.com/<?= $page->uid() ?>" rel="nofollow" target="_blank">
                                Report Changes
                            </a>
                        </li>
                    </ul>
                </aside>
            <!-- </li> -->

        </ul>

    </div>
</section>
