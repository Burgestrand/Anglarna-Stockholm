<?php echo form::open('user/login', array('class' => 'box login')) ?>
    <h2>Logga in</h2>
    <dl>
        <dt><label>Användarnamn <input type="text" name="username"></label></dt>
            <dd>
                Det användarnamn du fick när du registrerade dig.
            </dd>
        
        <dt><label>Lösenord <input type="password" name="password"></label></dt>
            <dd>
                Det lösenord du registrerade till din användare.
            </dd>
            <dd>
                Glömt ditt lösenord? Oroa dig inte, vi kan 
                <a href="user/recover">skicka ett nytt till din e-mail</a>.
            </dd>
    </dl>
    <p>
        <input type="submit" value="Logga in">
    </p>
</form>

<!-- TODO: Facebook Connect -->