<p class="meta">
    <?php
        
        echo $post->user->id ? html::chars($post->user->load()->username)
                             : html::chars($post->author) . ' (<strong>Gäst</strong>)';
        
        if (Auth::instance()->has_roles('moderator'))
        {
            printf(' (%s)', $post->ip);
        }
    ?>:
    <span class="date"><?php echo $post->created; ?></span>
</p>
<p>
    <?php echo html::chars($post->message) ?>
</p>