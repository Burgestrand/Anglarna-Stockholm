<?php
    foreach ($messages as $type => $msgs)
    {
        printf('<ul class="message %s">', html::chars($type));
        foreach ($msgs as $msg)
        {
            printf('<li>%s</li>', $msg);
        }
        print('</ul>');
    }
    
/* End of file messages.php */
/* Location: ./application/views/template/messages.php */ 