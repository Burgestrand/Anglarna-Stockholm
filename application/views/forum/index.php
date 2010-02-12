<!-- Forum Navigation -->
<?php
    if (count($forums) > 1)
    {
        echo View::factory('forum/navigation')->set('forums', $forums)->set('current', $forum->id);
    }
?> 

<!-- Forum form -->
<?php echo form::open('forum/post') ?> 
    <ul>
        <li>
            <label>Namn <input type="text" name="username" value="<?php echo $username ?>" class="voodoo"></label>
        </li>
        <li>
            <label>Meddelande <textarea rows="3" cols="80" name="message" class="voodoo"></textarea></label>
        </li>
    </ul>
    <p>
        <input type="submit" value="Publicera inlägg" class="voodoo">
    </p>
</form>
<hr>

<!-- Paging -->
<?php echo $paging ?>

<!-- Forum Posts -->
<ol class="posts">
<?php
    foreach ($forum->posts as $post)
    {
        printf('<li class="post">%s</li>', View::factory('forum/post')->set('post', $post));
    }
?> 
</ol>

<?php echo $paging ?>