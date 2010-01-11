<?php
    $request = Request::instance();
    $status  = $request->status;
    $title   = $status . ' :: ' . Request::$messages[$status];
    
    // Google search query
    $query = 'site:'.$_SERVER['SERVER_NAME'].' '
           . implode(' ', array($request->controller,
                                $request->action));
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html;charset=utf8">
        <title><?php echo $title ?></title>
        
        <link rel="stylesheet" href="/css/error.css" type="text/css" media="screen" charset="utf-8">
    </head>
    <body>
        <h1><?php echo $title ?></h1>
        <?php echo View::factory("errors/{$status}")->set('request', $request) ?>
        <p>
            Here are some suggestions to where you can go next.
        </p>
        <ul>
            <!-- Google Search -->
            <li><?php echo html::anchor('http://google.com/search?q='.$query
                                       ,'Try searching for it'); ?></li>

            <!-- Referrer -->
            <?php if (Request::$referrer): ?>
            <li><?php echo html::anchor(Request::$referrer, 'Go back to where you came from') ?></li>
            <?php endif; ?>

            <!-- Index -->
            <li><?php echo html::anchor('/', 'Start over from scratch') ?></li>
        </ul>
        <p>
            If you feel something is missing that should be here, feel free to
            <a href="/contact/">contact us</a>.
        </p>
    </body>
</html>