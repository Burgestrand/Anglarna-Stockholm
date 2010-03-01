<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * Static page
     *
     * @author      Kim Burgestrand
     * @license     http://www.fsf.org/licensing/licenses/agpl-3.0.html
     */
    class Controller_Arkiv extends Controller_Template
    {
        public function action_index()
        {
            parent::action_index();
            $this->template->title = 'Änglarna Stockholms arkiv';
        }
    }
    
/* End of file arkiv.php */
/* Location: ./application/classes/controller/arkiv.php */ 
