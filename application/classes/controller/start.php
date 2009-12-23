<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * Start page controller
     *
     * @category    Controllers
     * @author      Kim Burgestrand <kim@burgestrand.se>
     * @license     <http://www.gnu.org/licenses/lgpl-3.0.txt> LGPL v3
     */
    class Controller_Start extends My_Controller_Template
    {
        public function action_index()
        {
            $this->template->content = 'Hello, world!';
        }
    }
    
/* End of file welcome.php */
/* Location: ./application/classes/controller/welcome.php */ 