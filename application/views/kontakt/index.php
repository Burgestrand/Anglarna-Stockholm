<div class="box">
    <h2>Kontakta webmaster</h2>
    <p>
        Det här formuläret är till för att kontakta <em>webmaster</em> om
        saker som rör hemsidan, forumet mm. Handlar det om något annat är
        så får du gärna skicka ett mail till <?php echo html::mailto('stockholm@anglarna.se') ?>
        istället.
    </p>
    <?php echo form::open('kontakt') ?>
        <dl>
            <dt><label>Ditt namn: <input type="text" name="name" value="" class="voodoo"></label></dt>
                <dd>
                    Valfritt, men det är alltid trevligt att veta vem man pratar med.
                </dd>
        
            <dt><label>Din e-mail: <input type="text" name="e-mail" class="voodoo"></label></dt>
                <dd>
                    Din e-mail, också valfritt. Tänk på att om du inte fyller i
                    din e-mail så kan du inte heller få något svar.
                </dd>
        
            <dt><label>Meddelande: <textarea name="message" rows="4" cols="80" class="voodoo"></textarea></label></dt>
        </dl>
        <p><input type="submit" value="Skicka"></p>
    </form>
</div>