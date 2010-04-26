<p class="meta">
    <span class="name"><?php
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
            
            // Build post delete URL
            $url   = Request::instance()->uri(array('action' => 'delete'));
            $query = http_build_query(array(
                'referrer' => Request::instance()->uri(),
            ));
            
            echo ' ' . html::anchor("forum/post/delete/{$post->id}?{$query}", 'radera');
        }
    ?></span>
    <span class="date"><?php echo $post->created; ?></span>
</p>
<?php echo Model_Post::stylize($post->message) ?>