<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * @package     Änglarna STHLM
     * @author      Kim Burgestrand
     * @license     http://www.fsf.org/licensing/licenses/agpl-3.0.html
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
                // Assume user always has access to default forum!!
                $this->request->redirect('forum', 307);
            }
            
            $this->template->content = $content = View::factory('forum/index');
            $content->forums = $this->forums();
            
            // Forum
            $content->forum_id = $forum->id;
            
            // Display of posts
            $content->username = $this->auth->logged_in() ? $this->auth->get_user()->username : '';
            
            $posts = Sprig::factory('post', array('forum' => $forum->id));
            $ipp = 10;
            $content->paging = $paging = html::paging(arr::get($_GET, 'page', 1), 
                                                      ceil($posts->count() / $ipp),
                                                      5);
            $content->posts = $posts->load(DB::select()->offset(($paging->current - 1) * $ipp), $ipp);
        }
        
        /**
         * Post a new post in the current forum
         */
        public function action_post()
        {
            if ( ! empty($_POST))
            {
                // Fix the forum ID
                $_POST['forum'] = (int) Arr::get($_POST, 'forum', 0);
                
                // Check forum access levels
                $forum = Sprig::factory('forum', array('id' => $_POST['forum']))->load();
                if ($forum->loaded())
                {
                    $roles = $forum->roles->as_array(NULL, 'name');
                    if ( ! $this->auth->has_roles($roles))
                    {
                        $this->message_add('Du har inte tillgång till det angivna forumet.', 'error');
                        $this->request->redirect_back('/', 307);
                    }
                }
                
                // Set up fields
                $this->auth->logged_in() AND $_POST['user'] = $this->auth->get_user()->id;
                
                // Create post
                $post = Sprig::factory('post', $_POST);
                                
                try
                {
                    $post->create();
                }
                catch (Validate_Exception $e)
                {
                    foreach ($e->array->errors('forum/post') as $error)
                    {
                        $this->message_add($error, 'error');
                    }
                }
            }
            
            $this->request->redirect_back();
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
        }
    }
    
/* End of file forum.php */
/* Location: ./application/classes/controller/forum.php */ 
