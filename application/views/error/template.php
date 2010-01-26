<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html;charset=utf8">
        <title><?php echo $title ?></title>
        
        <link rel="stylesheet" href="/css/error.css" type="text/css" media="screen" charset="utf-8">
    </head>
    <body>
        <h1><?php echo $title ?></h1>
        
        <?php echo $content ?>
        
        <p>
            <?php echo __('Here are some suggestions to where you can go next.') ?>
        </p>
        <ul>
            <?php foreach($suggestions as $suggestion): ?>
            <li><?php echo $suggestion ?></li>
            <?php endforeach; ?>
        </ul>
        <p>
			<?php echo __('If you feel something is missing that should be here, feel free to ') . html::anchor('contact', __('contact us')) ?>
        </p>
    </body>
</html>