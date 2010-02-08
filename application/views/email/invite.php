<h1>Inbjudan hos Änglarna Stockholm</h1>
<hr>
<p>
    Du har blivit erbjuden att registrera en användare på <a href="http://stockholm.anglarna.se/">Änglarna Stockholms hemsida</a> av <?php echo html::chars($inviter) ?>.
</p>
<?php
    if ( ! empty($message)):
        printf('<p>%s meddelar också: %s</p>', html::chars($inviter),
                                               html::chars($message));
    endif;
?>
<p>
    Registrering sker på följande adress: <?php echo html::anchor($url, html::chars($url)) ?>.
</p>
<hr>
<p>
    Mvh, Änglarna Stockholm
</p>