<ul class="nav">
<?php
    foreach(array('index') as $link)
    {
        printf('<li%s>%s</li>',
                html::attributes(array('class' => Request::instance()->controller
                                                  == $link ? 'active' : NULL)),
                html::anchor($link, UTF8::ucfirst($link)));
    }
?> 
</ul>