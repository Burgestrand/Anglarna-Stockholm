<ul class="nav forums">
<?php
    foreach ($forums as $forum)
    {
        $active = $forum->id == $current ? ' class="active"' : '';
        printf('<li%s>%s</li>', $active, html::anchor("forum/{$forum->id}", $forum->name));
    }
?>
</ul>