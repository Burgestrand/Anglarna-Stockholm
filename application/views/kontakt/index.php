<div class="box">
    <h2>Kontakta Änglarna Stockholm</h2>
    <p>
        Det här formuläret är ett alternativ till att skicka ett mail till
        Änglarna Stockholm direkt. Det går lika bra att skicka ett mail
        till <?php echo html::mailto('stockholm@anglarna.se') ?>.
    </p>
    <?php echo form::open('kontakt') ?>
        <dl>
            <dt><label>Ditt namn: <input type="text" name="name" value="" class="voodoo" tabindex="1"></label></dt>
                <dd>
                    Valfritt, men det är alltid trevligt att veta vem man pratar med.
                </dd>
        
            <dt><label>Din e-mail: <input type="text" name="e-mail" class="voodoo" tabindex="1"></label></dt>
                <dd>
                    Din e-mail, också valfritt. Tänk på att om du inte fyller i
                    din e-mail så kan du inte heller få något svar.
                </dd>
        
            <dt><label>Meddelande: <textarea name="message" rows="4" cols="80" class="voodoo" tabindex="1"></textarea></label></dt>
        </dl>
        <p><input type="submit" value="Skicka" class="voodoo"></p>
    </form>
</div>