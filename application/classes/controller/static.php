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
            // Load the pages
            $this->template->content = View::factory("static/{$path}");
        }
        
        public function before()
        {
            $path = $this->request->param('path');
            $this->request->controller = substr($path, strpos($path, '/'));
            parent::before();
        }
    }
    
/* End of file static.php */
/* Location: ./application/classes/controller/static.php */ 