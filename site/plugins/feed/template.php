<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:wfw="http://wellformedweb.org/CommentAPI/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:atom="http://www.w3.org/2005/Atom">

    <channel>
        <title><?= xml($title) ?></title>
        <link><?= xml($link) ?></link>
        <lastBuildDate><?= date('r', $modified) ?></lastBuildDate>
        <atom:link href="<?php echo xml($url) ?>" rel="self" type="application/rss+xml" />
        <description><?= xml($site->description()->html()) ?></description>

        <?php foreach($items as $item): ?>
            <item>
                <title><?= xml($item->title()) ?></title>
                <link><?= xml($link . '/' . $item->uid()) ?></link>
                <guid><?= xml($link . '/' . $item->uid()) ?></guid>
                <pubDate><?= $item->date('r', 'created') ?></pubDate>
                <description>
                    <![CDATA[
                        <?= $item->description()->kirbytext() ?>
                    ]]>
                </description>
            </item>
        <?php endforeach ?>

  </channel>
</rss>
