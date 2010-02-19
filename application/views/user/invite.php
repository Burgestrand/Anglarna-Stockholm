<?php echo form::open('user/invite', array('class' => 'invite box')) ?>
    <h2>Bjud in en Ängel</h2>
    <dl>
        <dt><label>E-Mail: <input type="text" name="email" class="voodoo" tabindex="4"></label></dt>
            <dd>
                Ängeln kommer få en inbjudan och kommer, efter registrering,
                att få tillgång till det stängda forumet!
            </dd>
            
        <dt><label>Meddelande <textarea rows="3" cols="80" name="message" class="voodoo" tabindex="5"></textarea></label></dt>
            <dd>
                Valfritt meddelande som skickas med inbjudan.
            </dd>
    </dl>
    <p>
        <input type="submit" value="Skicka inbjudan" class="voodoo" tabindex="6">
    </p>
</form>