<?php echo form::open("user/register/{$invite->token}") ?>
    <fieldset>
        <legend>Registrera en ny användare</legend>
        <dl>
            <dt><label>Namn: <input type="text" name="username"></label></dt>
                <dd>
                    Det alias eller nick du vill ha för att logga in med.
                    Får inte vara längre än 50 tecken. Kan ändras i kontrollpanelen
                    när man är inloggad.
                </dd>
            
            <dt><label>Lösenord: <input type="password" name="password"></label></dt>
                <dd>
                    Önskat lösenord du vill använda till att logga in med.
                    Kan ändras i kontrollpanelen när man är inloggad.
                </dd>
        
            <dt><label>E-Mail: <input type="text" disabled="disabled" value="<?php echo html::chars($invite->email) ?>"></label></dt>
                <dd>
                    Den mailadress som registreras till ditt konto. Den går
                    att ändra efter registrering men inte innan dess. Adressen
                    används för att återställa glömda lösenord.
                </dd>
        </dl>
        <p>
            <input type="submit" value="Registrera">
        </p>
    </fieldset>
</form>