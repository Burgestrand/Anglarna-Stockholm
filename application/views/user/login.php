<?php echo form::open('user/login', array('class' => 'box login')) ?>
    <h2>Logga in</h2>
    <dl>
        <dt><label>Användarnamn <input type="text" name="username" maxlength="50" class="voodoo" tabindex="4"></label></dt>
        
        <dt><label>Lösenord <input type="password" name="password" class="voodoo" tabindex="5"></label></dt>
            <dd>
                Glömt ditt lösenord? Oroa dig inte, vi kan 
                <a href="<?php echo url::site('user/recover') ?>">skicka ett nytt till din e-mail</a>.
            </dd>
    </dl>
    <p>
        <input type="submit" value="Logga in" class="voodoo" tabindex="6">
    </p>
</form>

<!-- TODO: Facebook Connect -->