<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html;charset=utf-8">
        <title><?php echo $title ?></title>
        
        <meta name="author" content="*placeholder*">
        <meta name="description" content="*placeholder*">
        <meta name="keywords" content="*placeholder*">
        
        <link rel="shortcut icon" type="image/png" href="/favicon.png">
        
        <!-- YUI (reset, base) -->
        <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/yui/2.8.0r4/build/reset-fonts/reset-fonts.css"> 
        <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/yui/2.8.0r4/build/base/base-min.css">
        
        <!-- CSS Styles -->
        <link rel="stylesheet" href="/css/original/style.css" type="text/css" media="screen" title="Original" charset="utf-8">
    </head>
    <?php flush(); ?> 
    <body>
        <?php echo $content ?>
        
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="/js/main.js" type="text/javascript" charset="utf-8"></script>
    </body>
</html>