<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * @package     Änglarna STHLM
     * @author      Kim Burgestrand
     * @license     http://www.fsf.org/licensing/licenses/agpl-3.0.html
     */
    class Controller_Resor extends Controller_Template
    {
        /**
         * Lists recent news and presents a welcome page
         */
        public function action_index()
        {
            $this->template->content = View::factory('resor/index');
        }
        
        public function before()
        {
            parent::before();
            $this->template->title = 'Resor anordnade av Änglarna Stockholm';
        }
    }
    
/* End of file resor.php */
/* Location: ./application/classes/controller/resor.php */ 
