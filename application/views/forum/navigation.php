<ul class="nav forums">
<?php
    foreach ($forums as $forum)
    {
        $key    = $forum->{$forum->unique_key($current)};
        $active = $key == $current ? ' class="active"' : '';
        printf('<li%s>%s</li>', $active,
               html::anchor(Route::get('forum')->uri(array('forum' => rawurlencode($key))), 
                            $forum->name));
    }
?>
</ul>