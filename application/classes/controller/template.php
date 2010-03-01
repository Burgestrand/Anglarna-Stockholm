<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * Depends on “template” submodule.
     * 
     * @package     Änglarna STHLM
     * @author      Kim Burgestrand
     * @license     http://www.fsf.org/licensing/licenses/agpl-3.0.html
     */
    class Controller_Template extends Template_Controller_Template
    {
        public function action_index()
        {
            if ($this->template instanceof View)
            {
                $this->template->content = View::factory("{$this->request->controller}/{$this->request->action}");
            }
        }
        
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
            
            if ($this->template instanceof View)
            {
                $this->template->sidebar = View::factory('sidebar');
            }
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
