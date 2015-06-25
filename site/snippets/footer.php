
        <footer class="section  section--footer  footer">
            <div class="section__wrap">
                <p class="footer__credits">
                    <?= $site->copyright()->html() ?>
                </p>
                <?php snippet('components/footer-links') ?>
            </div>
        </footer>


        <?= js('//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js') ?>
        <script>window.jQuery || document.write('<script src="assets/js/jquery-1.11.1.min.js"><\/script>')</script>
        <?= js('assets/js/plugins.@@1435214329874.min.js') ?>
        <?= js('assets/js/main.@@1435214329874.min.js') ?>

        <?php snippet('tools/tracking') ?>

    </body>
</html>
