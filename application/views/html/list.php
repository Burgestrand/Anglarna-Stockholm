<?php
    // Make sure attributes follow standard
    is_array($attributes) OR $attributes = array();
    $type = $ordered ? 'ol' : 'ul';

    printf('<%s%s>', $type, html::attributes($attributes));
        
    foreach ($items as $item)
    {
        $item[0] = html::attributes($item[0]);
        vprintf('<li%s>%s</li>', $item);
    }
    
    printf('</%s>', $type);
    
/* End of file list.php */
/* Location: ./application/views/html/list.php */ 