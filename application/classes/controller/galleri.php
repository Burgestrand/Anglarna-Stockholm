<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * @package     Änglarna STHLM
     * @author      Kim Burgestrand
     * @license     http://www.gnu.org/licenses/gpl-3.0.txt
     */
    class Controller_Galleri extends Controller_Template
    {
        /**
         * Lists recent news and presents a welcome page
         */
        public function action_index()
        {
            $this->template->content = View::factory('galleri/index');
        }
    }
    
/* End of file galleri.php */
/* Location: ./application/classes/controller/galleri.php */ 