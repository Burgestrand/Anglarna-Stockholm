<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * @package     Änglarna STHLM
     * @category    Controllers
     * @author      Kim Burgestrand
     * @license     http://www.fsf.org/licensing/licenses/agpl-3.0.html
     */
    class Controller_Forum extends Template_Controller
    {
        protected $_forum;
        
        /**
         * Views the given forum, or the first valid forum
         */
        public function action_index($forum)
        {
            // View data
            $this->template->content = $content = View::factory('forum/index');
            $content->set('forum', $this->request->param('forum'));
            $content->bind('forums', $forums);
            
            // Fetch the proper forums
            if ($this->auth->has_roles('admin'))
            {
                $forums = Sprig::factory('forum')->load(NULL, 0);
            }
            else
            {
                $roles  = ($user = $this->auth->get_user()) ? $user->roles->as_array(NULL, 'id') : array();
                $forums = Sprig::factory('forum')->fetch($roles);
            }
            
            // Load View data
            $content->username = $this->auth->logged_in() ? $this->auth->get_user()->username : '';
            
            // Forum posts
            $posts = Sprig::factory('post', array('forum' => $this->_forum->id));
            $ipp = 25;
            $content->paging = $paging = html::paging(arr::get($_GET, 'page', 1), 
                                                      ceil($posts->count() / $ipp),
                                                      5);
            $content->posts = $posts->load(DB::select()->offset(($paging->current - 1) * $ipp), $ipp);
            $this->template->title = 'Änglarna Stockholms forum: ' . $this->_forum->name;
        }
        
        /**
         * Post a new post in the current forum
         */
        public function action_create()
        {
            if ( ! empty($_POST))
            {
                $_POST['forum'] = $this->_forum->id;
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
            
            $this->request->reload();
        }
        
        /**
         * Delete a post
         */
        public function action_delete()
        {
            if ($this->auth->has_roles('moderator'))
            {
                $id = max(arr::get($_POST, 'id'), 1);
                $post = Sprig::factory('post', array('id' => $id))->load();
                
                if ($post->loaded())
                {
                    $post->delete();
                    $this->template->content = json_encode("Post #{$post->id} har tagits bort");
                    return;
                }
                
                $this->request->status = 404;
                $this->template->content = json_encode("Post #{$post->id} hittades inte.");
                return;
            }
            
            $this->request->status = 403;
            $this->template->content = json_encode('Du har inte moderatorprivilegier.');
        }
        
        public function before()
        {
            parent::before();
            
            $param = $this->request->param('forum');
            $forum = Model_Forum::factory($param)->load();
            
            try
            {
                if ( ! $forum->loaded())
                {
                    throw new Kohana_Exception('Forumet :forum existerar inte.', array(
                        ':forum' => $param
                    ));
                }
            
                $roles = $forum->roles->as_array(NULL, 'name');
                if ( ! $this->auth->has_roles($roles))
                {
                    throw new Kohana_Exception('Du måste vara inloggad för att ha tillgång till forum/:forum.', array(
                        ':forum' => $forum->name,
                    ));
                }
            }
            catch (Kohana_Exception $e)
            {
                $this->message_add($e->getMessage(), 'error');
                $this->request->redirect('forum');
            }
            
            // Save forum for later use
            $this->_forum = $forum;
            
            // REST-thingy
            switch (Request::$method)
            {
                case 'POST': $this->request->action = 'create'; break;
                case 'DELETE': $this->request->action = 'delete'; break;
            }
        }
    }
    
/* End of file forum.php */
/* Location: ./application/classes/controller/forum.php */ 
