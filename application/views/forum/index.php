<!-- Forum Navigation -->
<?php
    if (count($forums) > 1)
    {
        echo View::factory('forum/navigation')->set('forums', $forums)->set('current', $forum_id);
    }
?> 

<!-- Forum form -->
<?php echo form::open('forum/post', array('class' => 'clear')) ?> 
    <ul>
        <li>
            <label>Namn <input type="text" name="author" value="<?php echo $username ?>" maxlength="50" class="voodoo"></label>
        </li>
        <li>
            <label>Meddelande <textarea rows="3" cols="80" name="message" class="voodoo"></textarea></label>
        </li>
    </ul>
    <p>
        <input type="submit" value="Publicera inlägg" class="voodoo">
    </p>
    <input type="hidden" name="forum" value="<?php echo $forum_id ?>">
</form>

<!-- Paging -->
<div id="posts"></div>
<?php echo $paging ?>

<!-- Forum Posts -->
<ol class="posts">
<?php
    if ($posts->count() >= 1):
        foreach ($posts as $post)
        {
            printf('<li class="post">%s</li>', View::factory('forum/post')->set('post', $post));
        }
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