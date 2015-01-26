<ul class="footer__nav  list-inline  footer-nav" role="navigation">
    <?php foreach(yaml($site->footerlinks()) as $link): ?>
        <li class="footer-nav__item">
            <a href="<?= $link['href'] ?>" target="_blank"><?= $link['title'] ?></a>
        <!--</li>-->
    <?php endforeach ?>
</ul>
