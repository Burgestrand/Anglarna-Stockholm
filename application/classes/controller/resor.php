<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * @author      Kim Burgestrand
     * @license		GNU GPLv3 http://www.gnu.org/licenses/gpl-3.0.txt
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
    }
    
/* End of file resor.php */
/* Location: ./application/classes/controller/resor.php */ 