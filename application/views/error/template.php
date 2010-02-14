<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html;charset=utf8">
        <title><?php echo $title ?></title>
        
        <!-- YUI (reset, base) -->
        <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/yui/2.8.0r4/build/reset-fonts/reset-fonts.css"> 
        <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/yui/2.8.0r4/build/base/base-min.css">
        
        <link rel="stylesheet" href="/css/error.css" type="text/css" media="screen" charset="utf-8">
    </head>
    <body>
        <h1><?php echo $title ?></h1>
        
        <?php echo $content ?>
        
        <p>
            <?php echo __('Här är någa förslag som du kan försöka med istället:') ?>
        </p>
        <ul>
            <?php foreach($suggestions as $suggestion): ?>
            <li><?php echo $suggestion ?></li>
            <?php endforeach; ?>
        </ul>
        <p>
			<?php echo __('Om du känner att något saknas som faktiskt bör vara här får du gärna ') . html::mailto('stockholm@anglarna.se', __('kontakta&nbsp;oss')) ?>!
        </p>
    </body>
</html>