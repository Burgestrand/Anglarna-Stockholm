<!-- Allsvenskan 2010 -->

<?php
    if (Auth::instance()->logged_in())
    {
        echo View::factory('user/invite');
    }
    else
    {
        echo View::factory('user/login');
    }
?>

<div class="section maillist box">
    <h2>Maillistan</h2>
    <p>
        Vi har en maillista som vi gör ett och annat utskick på. Skicka
        ett mail till <?php echo html::mailto('stockholm@anglarna.se') ?>
        så lägger vi till dig!
    </p>
</div>