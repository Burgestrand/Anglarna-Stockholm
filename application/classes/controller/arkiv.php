<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * Static page
     *
     * @author      Kim Burgestrand
     * @license     http://www.gnu.org/licenses/gpl-3.0.txt
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