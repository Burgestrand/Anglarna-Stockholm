<p class="meta">
    <?php
        // authentic author?
        $guest = ! $post->user->id || 
                 $post->user->load()->username !== $post->author;
        
        echo html::chars($post->author);
        $guest AND printf(' (<strong>%s</strong>)', __('Guest'));
        
        if (Auth::instance()->has_roles('moderator'))
        {
            echo ' (';
            if ($guest && $post->user->id)
            {
                echo $post->user->username . '@';
            }
            echo $post->ip;
            echo ')';
        }
    ?>:
    <span class="date"><?php echo $post->created; ?></span>
</p>
<p>
    <?php echo html::chars($post->message) ?>
</p>