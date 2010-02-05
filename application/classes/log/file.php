<?php
    /**
     * Extends the Kohana_Log_File to handle objects.
     *
     * @package     Änglarna STHLM
     * @category    Logging
     * @author      Kim Burgestrand <kim@burgestrand.se>
     * @license     http://www.gnu.org/licenses/lgpl-3.0.txt
     */
    class Log_File extends Kohana_Log_File
    {
        public function write(array $messages)
        {
            foreach ($messages as $key => $message)
            {
                if (is_object($message['body']) && $message['body'] instanceof Exception)
                {
                    $messages[$key]['body'] = Kohana::exception_text($message['body']);
                }
            }
            
            parent::write($messages);
        }
    }
    
/* End of file file.php */
/* Location: ./application/classes/log/file.php */ 