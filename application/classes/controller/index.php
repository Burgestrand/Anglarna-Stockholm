<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * @author      Kim Burgestrand <kim@burgestrand.se>
     * @license     http://www.gnu.org/licenses/lgpl-3.0.txt
     */
    class Controller_Index extends My_Controller_Template
    {
        public function action_index()
        {
            $this->template->content = 'This space is intentionally left blank.';
        }
    }
    
/* End of file welcome.php */
/* Location: ./application/classes/controller/welcome.php */ 