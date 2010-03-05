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
        public function action_index($forum)
        {
            // Load the current forum
            $forum = Model_Forum::factory($forum)->load();
            
            // Load View data
            $this->template->content = $content = View::factory('forum/index');
            
            $content->forum = $this->request->param('forum');
            $content->forums = $this->forums();
            $content->username = $this->auth->logged_in() ? $this->auth->get_user()->username : '';
            
            // Forum posts
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
        public function action_post($forum)
        {
            if ( ! empty($_POST))
            {
                $_POST['forum'] = Model_Forum::factory($forum)->load()->id;
                $this->auth->logged_in() AND $_POST['user'] = $this->auth->get_user()->id;
                
                try
                {
                    Sprig::factory('post', $_POST)->create();
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
            
            $param = $this->request->param('forum');
            $forum = Model_Forum::factory($param)->load();
            
            if ( ! $forum->loaded())
            {
                throw new Kohana_Exception('Forumet :forum existerar inte', array(
                    ':forum' => $param
                ));
            }
            
            $roles = $forum->roles->as_array(NULL, 'name');
            if ( ! $this->auth->has_roles($roles))
            {
                throw new Kohana_Exception('Otillräckliga privilegier för :forum', array(
                    ':forum' => $param,
                ));
            }
        }
    }
    
/* End of file forum.php */
/* Location: ./application/classes/controller/forum.php */ 
