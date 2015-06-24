
        <footer class="section  section--footer  footer">
            <div class="section__wrap">
                <p class="footer__credits">
                    <?= $site->copyright()->html() ?>
                </p>
                <?php snippet('components/footer-links') ?>
            </div>
        </footer>


        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="assets/js/jquery-1.11.1.min.js"><\/script>')</script>
        <script src="assets/js/plugins.@@1435134365524.min.js"></script>
        <script src="assets/js/main.@@1435134365524.min.js"></script>

        <?php snippet('tools/tracking') ?>

    </body>
</html>
