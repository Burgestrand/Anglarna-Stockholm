<?php echo form::open("user/register?token={$invite->token}", array('class' => 'box')) ?>
    <h2>Registrera dig som Ängel!</h2>
    <dl>
        <dt><label>Namn <input type="text" name="username" class="voodoo" maxlength="50"></label></dt>
            <dd>
                Det alias eller nick du vill ha för att logga in med.
                Får inte vara längre än 50 tecken.
            </dd>
        
        <dt><label>Lösenord <input type="password" name="password" class="voodoo"></label></dt>
            <dd>
                Hitta på ett lösenord som du vill ha associerat till ditt konto
                och skriv in det i rutan ovan. Detta används när du loggar in.
            </dd>
    
        <dt><label>E-Mail <input type="text" disabled="disabled" value="<?php echo html::chars($invite->email) ?>" class="voodoo"></label></dt>
            <dd>
                Den mailadress som registreras till ditt konto. Den går
                att ändra efter registrering men inte innan dess. Adressen
                används för att återställa glömda lösenord.
            </dd>
    </dl>
    <p>
        <input type="submit" value="Registrera" class="voodoo">
    </p>
</form>