<p class="meta">
    <?php 
        echo html::chars($post->author);
        if (Auth::instance()->has_roles('moderator'))
        {
            printf(' (%s:%s)', $post->user->load()->username, 
                                  $post->ip);
        }
    ?>:
    <span class="date"><?php echo $post->created; ?></span>
</p>
<p>
    <?php echo html::chars($post->message) ?>
</p>