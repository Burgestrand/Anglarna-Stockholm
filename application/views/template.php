<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html;charset=utf-8">
        <title><?php echo html::chars($title) ?></title>
        
        <link rel="icon" type="image/png" href="<?php echo url::site('favicon.png') ?>">
        
        <!-- YUI (reset, base) -->
        <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/yui/2.8.0r4/build/reset-fonts/reset-fonts.css"> 
        <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/yui/2.8.0r4/build/base/base-min.css">
        
        <!-- CSS Styles -->
        <link rel="stylesheet" href="<?php echo url::site('css/original/style.css') ?>" type="text/css" media="screen" title="Original">
        <!--[if lt IE 8]>
            <link rel="stylesheet" href="<?php echo url::site('css/original/ie7.css') ?>" type="text/css" media="screen">
        <![endif]-->
    </head>
    <?php flush(); ?> 
    <body>
        <?php echo View::factory('user/panel') ?>
        <div class="section main">
            <div class="header">
                <a class="logo" href="<?php echo url::site('/') ?>"><img src="<?php echo url::site('img/header.jpg') ?>" alt="Änglarna Stockholm" width="746" height="107"></a>
                <?php echo View::factory('navigation')->set('links', array('start', 'forum', 'kontakt')) ?>
                <div class="clear"></div>
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
        <script src="<?php echo url::site('js/jquery.textarearesizer.compressed.js') ?>" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo url::site('js/main.js') ?>" type="text/javascript" charset="utf-8"></script>
        <!--[if lt IE 8]>
        <script type="text/javascript">
            $('.voodoo').each(function() {
                var width = $(this).width()
                width -= ($(this).outerWidth(true) - width)
                $(this).width(width + 'px')
            })
        </script>
        <![endif]-->
    </body>
</html>