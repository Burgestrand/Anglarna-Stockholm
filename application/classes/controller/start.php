<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * @author      Kim Burgestrand
     * @license		GNU GPLv3 http://www.gnu.org/licenses/gpl-3.0.txt
     */
    class Controller_Start extends Controller_Template
    {
        /**
         * Lists recent news and presents a welcome page
         */
        public function action_index()
        {
            
        }
        
        public function before()
        {
            parent::before();
            View::set_global('title', 'Änglarna Stockholm');
        }
    }

/* End of file start.php */
/* Location: ./application/classes/controller/start.php */ 