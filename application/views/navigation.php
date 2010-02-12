<ul class="nav pages">
<?php
    foreach($links as $link)
    {
        printf('<li%s>%s</li>',
                html::attributes(array('class' => Request::instance()->controller
                                                  == $link ? 'active' : NULL)),
                html::anchor($link, UTF8::ucfirst($link)));
    }
?> 
</ul>