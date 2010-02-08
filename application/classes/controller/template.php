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
        
        /**
         * Authorize a user from the given roles, or return
         * the user with a 403 message
         *
         * @param roles
         */
        public function authorize()
        {
            $args = func_get_args();
            
            if ( ! $this->auth->logged_in($args))
            {
                $this->message_add('Du har inte åtkomst till ' . html::chars($this->request->uri));
                $this->request->redirect('/', 307);
            }
        }
    }
    
/* End of file template.php */
/* Location: ./application/classes/controller/template.php */ 