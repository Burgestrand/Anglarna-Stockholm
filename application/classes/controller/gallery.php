<?php defined('SYSPATH') OR die('No direct access allowed.');

    /**
     * Gallery
     *
     * @package     Änglarna STHLM
     * @author      Kim Burgestrand
     * @license     http://www.fsf.org/licensing/licenses/agpl-3.0.html
     */
    class Controller_Gallery extends Controller_Template
    {
        public function action_index()
        {
            $this->template->content = View::factory('galleri/index')
                                           ->set('galleries', Model_Gallery::factory()->load(NULL, 0));
        }
        
        public function action_view($galleri)
        {
            $this->template->title   = 'Änglarna Stockholms galleri: ' . html::chars($galleri);
            $this->template->content = View::factory('galleri/view')
                                           ->set('images', Model_Gallery::factory($galleri)->load()->images)
                                           ->set('title', $galleri);
        }
        
        /**
         * Overload to reroute to view-action if a gallery is defined
         */
        public function before()
        {
            parent::before();
            
            if ($galleri = $this->request->param('galleri'))
            {
                $this->request->action = 'view';
            }
        }
    }
    
/* End of file galleri.php */
/* Location: ./application/classes/controller/galleri.php */ 