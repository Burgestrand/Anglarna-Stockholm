<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * @package     Änglarna STHLM
     * @author      Kim Burgestrand
     * @license     http://www.gnu.org/licenses/gpl-3.0.txt
     */
    class Controller_Forum extends Controller_Template
    {
        /**
         * Views the given forum, or the first valid forum
         */
        public function action_index()
        {
            // Load the current forum
            $forum = $this->request->param('forum', 1);
            $forum = Sprig::factory('forum', array('id' => $forum))->load();
            
            // Make sure the current user has access to the forum
            $roles = $forum->roles->as_array(NULL, 'name');
            if ( ! $this->auth->has_roles($roles))
            {
                $this->message_add('Du har inte tillgång till det angivna forumet', 'error');
                $this->request->redirect_back('/', 307);
            }
            
            $this->template->content = $content = View::factory('forum/index');
            $content->forums = $this->forums();
            
            $content->username = $this->auth->logged_in() ? $this->auth->get_user()->username : '';
            $content->paging = View::factory('forum/paging');
            $content->forum = $forum;
        }
        
        /**
         * Post a new post in the current forum
         */
        public function action_post()
        {
            
        }
        
        /**
         * List all forums the current user has access to
         * 
         * @return array
         */
        public function forums()
        {
            $forums = array();
            
            foreach (Sprig::factory('forum')->load(NULL, 0) as $forum)
            {
                $roles = $forum->roles->as_array(NULL, 'name');
                
                if ($this->auth->has_roles($roles))
                {
                    $forums[] = $forum;
                }
            }
            
            return $forums;
        }
        
        public function before()
        {
            parent::before();
            $this->template->title = 'Änglarna Stockholms forum';
            $this->template->sidebar = View::factory('sidebar');
        }
    }
    
/* End of file forum.php */
/* Location: ./application/classes/controller/forum.php */ 