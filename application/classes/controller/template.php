<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * Depends on “template” submodule.
     * 
     * @author      Kim Burgestrand
     * @license     GNU GPLv3 http://www.gnu.org/licenses/gpl-3.0.txt
     */
    class Controller_Template extends Template_Controller_Template
    {
        public function before()
        {
            parent::before();
            $this->session = Session::instance('database');
            $this->auth    = Auth::instance();
        }
    }
    
/* End of file template.php */
/* Location: ./application/classes/controller/template.php */ 