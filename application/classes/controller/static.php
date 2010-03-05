<?php defined('SYSPATH') OR die('No direct access allowed.');
    
    /**
     * Static controller
     *
     * @package     Änglarna STHLM
     * @author      Kim Burgestrand
     * @license     http://www.fsf.org/licensing/licenses/agpl-3.0.html
     */
    class Controller_Static extends Controller_Template
    {
        public function action_load($controller, $action)
        {
            $path = "{$controller}/{$action}";
            
            // Alter for navigation purposes
            Request::instance()->controller = $controller;
            Request::instance()->action     = $action;
            
            // Load the pages
            $this->template->title   = Kohana::message('titles', $path);
            $this->template->content = View::factory($path);
        }
    }
    
/* End of file static.php */
/* Location: ./application/classes/controller/static.php */ 