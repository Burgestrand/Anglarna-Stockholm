<?php echo form::open('user/invite', array('class' => 'invite box')) ?>
    <h2>Bjud in en Ängel</h2>
    <dl>
        <dt><label>E-Mail: <input type="text" name="email"></label></dt>
            <dd>
                Ängeln kommer få en inbjudan och kommer efter registrering
                att få tillgång till det stängda forumet!
            </dd>
        <dt>
            <label for="message">Meddelande</label>
            <textarea name="message"></textarea>
        </dt>
            <dd>
                Valfritt meddelande som skickas med inbjudan.
            </dd>
    </dl>
    <p>
        <input type="submit" value="Skicka inbjudan">
    </p>
</form>