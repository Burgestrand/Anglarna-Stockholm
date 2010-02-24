<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * An extension to the View to search for markdown documents as well
     *
     * @package     Änglarna STHLM
     * @author      Kim Burgestrand
     * @license     http://www.gnu.org/licenses/gpl-3.0.txt
     */
    
    // Required
    require_once Kohana::find_file('vendor', 'markdown/markdown');
    
    class View extends Kohana_View
    {
        private $_markdown = FALSE;

        public function set_filename($file)
        {
            try
            {
                parent::set_filename($file);
            }
            catch (Kohana_View_Exception $e)
            {
                if (($path = Kohana::find_file('views', $file, 'md')) === FALSE)
                {
                    throw $e; // re-throw
                }
                
                $this->_markdown = TRUE;
                $this->_file = $path;
            }
            
            return $this;
        }
        
        public function render($file = NULL)
        {
            $file = parent::render($file);
            return $this->_markdown ? Markdown($file) : $file;
        }
    }

/* End of file markdown.php */
/* Location: ./application/classes/markdown.php */ 