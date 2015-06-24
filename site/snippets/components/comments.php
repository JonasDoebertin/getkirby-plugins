
<section class="section  section--comments  comments">
    <div class="section__wrap">

        <h4 class="comments__headline">
            Comments &amp; Discussions
        </h4>

        <div id="disqus_thread"></div>
        <script type="text/javascript">

            /* * * CONFIGURATION VARIABLES * * */
            var disqus_shortname = 'getkirby-plugins',
                disqus_identifier = 'plugin/<?= $page->uid() ?>',
                disqus_title = '<?= $page->title() ?> Plugin';

            /* * * DON'T EDIT BELOW THIS LINE * * */
            (function() {
                var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
            })();
        </script>
        <noscript>Please enable JavaScript to view the comments.</noscript>

    </div>
</section>
