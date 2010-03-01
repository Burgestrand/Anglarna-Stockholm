<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * Static page
     *
     * @author      Kim Burgestrand
     * @license     http://www.fsf.org/licensing/licenses/agpl-3.0.html
     */
    class Controller_Om extends Controller_Template
    {
        public function action_index()
        {
            $this->request->redirect('om/hemsidan');
        }
        
        public function action_hemsidan()
        {
            $this->template->title = 'Information om hemsidan';
            $this->template->content = View::factory('om/hemsidan');
        }
    }
    
/* End of file om.php */
/* Location: ./application/classes/controller/om.php */ 