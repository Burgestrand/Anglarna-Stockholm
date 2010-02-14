<h1>Inbjudan hos Änglarna Stockholm</h1>
<p>
    Du har blivit erbjuden att registrera en användare på Änglarna Stockholms hemsida av <?php echo html::chars($inviter) ?>.
</p>
<?php
    if ( ! empty($message)):
        printf('<p>%s meddelar också</p><pre>%s</pre>', html::chars($inviter),
                                                        html::chars($message));
    endif;
?>
<p>
    Registrering sker på följande adress: <?php echo html::anchor($url, html::chars($url)) ?>.
</p>
<p>
    Mvh, Änglarna Stockholm
</p>