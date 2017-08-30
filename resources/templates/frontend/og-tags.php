<meta property="og:title" content="<?php echo $title; ?>"/>
<meta property="og:description" content="<?php echo $description; ?>"/>
<meta property="og:url" content="<?php echo $url; ?>"/>
<?php foreach ($imgSrcs as $imgSrc) : ?>
    <meta property="og:image" content="<?php echo $imgSrc; ?>"/>
<?php endforeach; ?>
