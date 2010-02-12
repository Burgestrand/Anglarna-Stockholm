<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html;charset=utf-8">
        <title><?php echo html::chars($title) ?></title>
        
        <meta name="author" content="">
        <meta name="description" content="">
        <meta name="keywords" content="">
        
        <link rel="icon" type="image/png" href="/favicon.png">
        
        <!-- YUI (reset, base) -->
        <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/yui/2.8.0r4/build/reset-fonts/reset-fonts.css"> 
        <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/yui/2.8.0r4/build/base/base-min.css">
        
        <!-- CSS Styles -->
        <link rel="stylesheet" href="/css/original/style.css" type="text/css" media="screen" title="Original">
    </head>
    <?php flush(); ?> 
    <body>
        <?php echo View::factory('panel') ?>
        <div class="section main">
            <div class="header">
                <a class="logo" href="/"><img src="/img/header.jpg" alt="Änglarna Stockholm" width="746" height="107"></a>
                <?php echo View::factory('navigation')->set('links', array('start', 'resor', 'forum')) ?>
            </div>
            <hr class="hide">
            <div class="section body <?php empty($sidebar) or print('sidebar') ?>">
                <?php 
                    foreach ($messages as $type => $msgs)
                    {
                        printf('<ul class="message %s">', html::chars($type));
                        foreach ($msgs as $msg)
                        {
                            printf('<li>%s</li>', $msg);
                        }
                        print('</ul>');
                    }
                    
                    echo $content;
                ?>
            </div>
            <?php
                if ( ! empty($sidebar))
                {
                    print '<hr class="hide">';
                    printf('<div class="aside">%s</div>', $sidebar);
                }
            ?>
            <div class="clear"></div>
        </div>
                
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="/js/main.js" type="text/javascript" charset="utf-8"></script>
    </body>
</html>