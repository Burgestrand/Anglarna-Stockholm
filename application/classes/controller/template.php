<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * Depends on “template” submodule.
     * 
     * @package     Änglarna STHLM
     * @author      Kim Burgestrand
     * @license     http://www.fsf.org/licensing/licenses/agpl-3.0.html
     */
    class Controller_Template extends Koxtend_Controller_Template
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
            
            if ($this->template instanceof View)
            {
                $this->template->sidebar = View::factory('sidebar');
            }
        }
        
        /**
         * Removes Messages that’s been displayed and set title
         */
        public function after()
        {
            if ($this->template instanceof View)
            {
                if (empty($this->template->title))
                {
                    $this->template->title = Kohana::message('titles', "{$this->request->controller}/{$this->request->action}");
                }
            }
            
            unset($_SESSION['messages']);
            parent::after();
        }
    }
    
/* End of file template.php */
/* Location: ./application/classes/controller/template.php */ 
