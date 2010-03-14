<?php defined('SYSPATH') OR die('No direct access allowed.');
    
    /**
     * Static controller
     *
     * @package     Änglarna STHLM
     * @author      Kim Burgestrand
     * @license     http://www.fsf.org/licensing/licenses/agpl-3.0.html
     */
    class Controller_Static extends Template_Controller
    {
        public function action_load($path)
        {
            list($controller, $action) = arr::merge(explode('/', $path), array('index'));
            
            // Alter for navigation purposes
            Request::instance()->controller = $controller;
            Request::instance()->action     = $action;
            
            // Load the pages
            $this->template->content = View::factory("static/{$path}");
        }
    }
    
/* End of file static.php */
/* Location: ./application/classes/controller/static.php */ 