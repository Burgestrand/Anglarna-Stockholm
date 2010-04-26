<!-- Forum Navigation -->
<?php
    if (count($forums) > 1)
    {
        echo View::factory('forum/navigation')->set('forums', $forums)->set('current', $forum);
    }
?> 

<!-- Forum form -->
<?php echo form::open(Route::get('forum')->uri(array('forum' => rawurlencode($forum))), array('class' => 'clear')) ?> 
    <dl>
        <dt>
            <label>Namn <input type="text" name="author" value="<?php echo $username ?>" maxlength="50" class="voodoo" tabindex="1"></label>
        </dt>
            <dd>
                Om du inte är inloggad, eller om du postar med annat nick än ditt eget, markeras du som Gäst.
            </dd>
            
        <dt>
            <label>Meddelande <textarea rows="3" cols="80" name="message" class="voodoo" tabindex="2"></textarea></label>
        </dt>
        <dd></dd>
    </dl>
    <p>
        <input type="submit" value="Publicera inlägg" class="voodoo" tabindex="3">
    </p>
</form>

<!-- Paging -->
<div id="posts"></div>
<?php echo $paging ?>

<!-- Forum Posts -->
<ol class="posts">
<?php
    if ($posts->count() >= 1):
        foreach ($posts as $post): ?>
        <li class="post" id="post<?php echo $post->id ?>">
            <?php echo View::factory('forum/post')->set('post', $post) ?> 
        </li>
<?php
        endforeach;
    else: ?>
    <li>
        <p class="meta">
            Webmaster:
        </p>
        <p>
            Det finns inga inlägg i det här forumet ännu. Jag tycker att <em>du</em> ska skriva det första!
        </p>
    </li>
<?php endif; ?>
</ol>

<?php echo $paging ?>