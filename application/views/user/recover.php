<?php echo form::open('user/recover', array('class' => 'box')) ?>
    <h2>Glömt ditt lösenord?</h2>
    <p>
        Kan du inte minnas ditt lösenord? Bara lugn, det händer alla någon
        gång. Skriv in din e-mail och tryck på knappen så skickas ett nytt 
        lösenord till din mailadress.
    </p>
    <dl>
        <dt><label>Din e-mail: <input type="text" name="e-mail" class="voodoo"></label></dt>
            <dd>
                Det här måste vara den mailadress som är kopplat till ditt konto.
            </dd>
    </dl>
    <p>
        <input type="submit" value="Skicka lösenord" class="voodoo">
    </p>
</form>