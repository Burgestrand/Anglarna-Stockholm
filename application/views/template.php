<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html;charset=utf-8">

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="<?php echo url::site('favicon.png') ?>">

        <!-- YUI (reset, base) -->
        <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/yui/2.8.0r4/build/reset-fonts/reset-fonts.css"> 
        <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/yui/2.8.0r4/build/base/base-min.css">

        <!-- Shadowbox -->
        <link rel="stylesheet" type="text/css" href="<?php echo url::site('js/shadowbox-3.0.3/shadowbox.css')?>">

        <!-- CSS Styles -->
        <link rel="stylesheet" href="<?php echo url::site('css/original/style.css') ?>" type="text/css" media="screen" title="Original">
        <!--[if lt IE 8]>
            <link rel="stylesheet" href="<?php echo url::site('css/original/ie7.css') ?>" type="text/css" media="screen">
        <![endif]-->

        <title><?php echo html::chars($title) ?></title>
    </head>
    <body>
        <?php echo View::factory('user/panel') ?>
        <div class="section main">
            <div class="header">
                <a class="logo" href="<?php echo url::site('/') ?>"><img src="<?php echo url::site('img/header.jpg') ?>" alt="Änglarna Stockholm" width="746" height="107"></a>
                <?php
                    echo $navigation
                ?> 
                <div class="clear"></div>
            </div>
            <hr class="hide">
            <div class="section body <?php empty($sidebar) or print('sidebar') ?>">
                <?php 
                    echo View::factory('koxtend/messages');
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
            <p class="footer">
                <?php echo html::anchor('om/hemsidan', 'om hemsidan') ?>
            </p>
        </div>

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo url::site('js/shadowbox-3.0.3/shadowbox.js') ?>" type="text/javascript" charset="utf-8"></script>
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