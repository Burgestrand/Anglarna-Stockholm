<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * Depends on “template” submodule.
     * 
     * @package     Änglarna STHLM
     * @author      Kim Burgestrand
     * @license     GNU GPLv3 http://www.gnu.org/licenses/gpl-3.0.txt
     */
    class Controller_Template extends Template_Controller_Template
    {
        /**
         * Initializes Session, Auth and Messages
         */
        public function before()
        {
            parent::before();
            $this->session = Session::instance('database');
            $this->auth    = Auth::instance();
            
            $this->messages += Arr::get($_SESSION, 'messages', array());
            $_SESSION['messages'] = &$this->messages;
        }
        
        /**
         * Removes Messages that’s been displayed
         */
        public function after()
        {
            parent::after();
            unset($_SESSION['messages']);
        }
    }
    
/* End of file template.php */
/* Location: ./application/classes/controller/template.php */ 