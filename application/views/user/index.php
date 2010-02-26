<?php echo form::open('user', array('class' => 'box')) ?>
    <h2><?php echo html::chars($user->username) ?></h2>
    <dl>
        <dt><label>E-Mail <input type="text" name="email" value="<?php echo html::chars($user->email) ?>" class="voodoo"></label></dt>
            <dd>
                Detta är din nuvarande mailadress. Om du glömmer bort ditt lösenord är din
                mailadress det enda sättet att få tillbaka ditt konto.
            </dd>
        <dt><label>Lösenord <input type="password" name="password" class="voodoo"></label></dt>
            <dd>
                Om du vill byta lösenord skriver du in önskat lösenord i rutan ovan och trycker på “Uppdatera”.
            </dd>
    </dl>
    <p>
        <input type="submit" value="Uppdatera profil" class="voodoo">
    </p>
</form>