<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * @package     Änglarna STHLM
     * @author      Kim Burgestrand
     * @license     http://www.gnu.org/licenses/gpl-3.0.txt
     */
    class Controller_Start extends Controller_Template
    {
        /**
         * Lists recent news and presents a welcome page
         */
        public function action_index()
        {
            $this->template->content = View::factory('start/index');
        }
        
        public function before()
        {
            parent::before();
            $this->template->title = 'Information om Änglarna Stockholm';
        }
    }

/* End of file start.php */
/* Location: ./application/classes/controller/start.php */