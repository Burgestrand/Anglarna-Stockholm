<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * @package     Änglarna STHLM
     * @author      Kim Burgestrand
     * @license     http://www.gnu.org/licenses/gpl-3.0.txt
     */
    class Controller_User extends Controller_Template
    {
        public function action_index()
        {
            if ( ! $this->auth->logged_in())
            {
                $this->request->redirect_back();
            }
            else
            {
                $username = $this->auth->get_user()->username;
                $username = rawurlencode($username);
                $this->request->redirect("user/view/{$username}");
            }
        }
        
        /**
         * Recover a lost password
         */
        public function action_recover()
        {
            if ( ! empty($_POST))
            {
                
            }
            $this->message_add('Jag har inte gjort den här funktionen ännu, men den är på gång.', 'error');
            
            $this->template->content = View::factory('user/recover');
        }
        
        /**
         * User view
         */
        public function action_view($user = NULL)
        {
            // Temporary ALWAYS redirect
            $this->request->redirect('forum');
            
            if (empty($user))
            {
                $this->template->content = $content = View::factory('user/list');
                $content->users = Sprig::factory('user')->select_list();
            }
            else
            {
                $user = Model_User::factory($user)->load();
                
                $this->template->title = html::chars($user->username) . 's profil hos Änglarna Stockholm';
                $this->template->content = $content = View::factory('user/view');
                $content->user = (object)$user->as_array();
                unset($content->user->password);
                
                // Set flag to show edit controls
                $content->owner = FALSE;
                if ($this->auth->logged_in())
                {
                    $content->owner = $user->id = $this->auth->get_user()->id;
                }
            }
        }
        
        /**
         * Creates a new invitation!
         */
        public function action_invite()
        {
            // Make sure we have these roles
            if ( ! $this->auth->has_roles(array('login', 'ängel')))
            {
                $this->message_add('Bara inloggade <em>änglar</em> får bjuda in nya medlemmar!', 'error');
                $this->request->redirect_back();
            }
            
            if ( ! empty($_POST))
            {
                $user = $this->auth->get_user();
                
                $_POST += array(
                    'token' => sha1(uniqid()),
                    'inviter' => $user->id
                );
                
                $invite = Sprig::factory('invite', $_POST);
                
                try
                {
                    $invite->create();
                    
                    // E-Mail
                    $email = View::factory('email/invite')
                             ->set('inviter', $user->username)
                             ->set('message', arr::get($_POST, 'message', ''))
                             ->set('url', url::site("user/register/{$invite->token}", true));
                    
                    // Send it!
                    Email::send($invite->email, 
                                $user->email, 
                                '[Änglarna Stockholm] Du kan nu registrera dig på Änglarna Stockholms hemsida!',
                                (string)$email, TRUE);
                    
                    // Success message! YAY!
                    $this->message_add(sprintf('Din inbjudan har skickats iväg till %s.',
                                               html::chars($invite->email)));
                    
                    $this->request->redirect_back();
                }
                catch (Exception $e)
                {
                    $invite->delete();
                    
                    if ($e instanceof Validate_Exception)
                    {
                        foreach ($e->array->errors('user/invite') as $error)
                        {
                            $this->message_add($error, 'error');
                        }
                    }
                    else
                    {
                        throw $e;
                    }
                }
            }
            
            $this->request->redirect_back();
        }
        
        /**
         * Logs the user out, nothing more.
         */
        public function action_logout()
        {
            $this->auth->logout();
            $this->message_add('Du har nu loggats ut.');
            $this->request->redirect_back('/');
        }
        
        /**
         * Logs the user in using the specified credentials.
         */
        public function action_login()
        {
            if ( ! empty($_POST))
            {
                $username = Arr::get($_POST, 'username', '');
                $password = Arr::get($_POST, 'password', '');
                
                if ( ! $this->auth->login($username, $password))
                {
                    $this->message_add('Fel användarnamn eller lösenord.', 'error');
                    $this->message_add(
                        sprintf('Om du har glömt ditt lösenord kan vi 
                                 <a href="/user/recover/%s">skicka ett nytt</a>!', 
                                 rawurlencode($username)));
                }
            }
            
            $this->request->redirect_back();
        }
        
        /**
         * Registration procedure (from a given invitation)
         */
        public function action_register($token = NULL)
        {
            $this->auth->logged_in('admin') || $this->auth->logout();
            
            if ( ! Model_Invite::valid($token))
            {
                $this->message_add('Din inbjudan är ogiltig.', 'error'); // TODO: better message
                $this->request->redirect_back();
            }
            else
            {
                $invite = Model_Invite::factory($token)->load();
            }
            
            // Registrera användare
            if ( ! empty($_POST))
            {
                $_POST['email'] = $invite->email;
                $_POST['logins'] = 0;
                $user = Sprig::factory('user', $_POST);
                
                /**
                 * The following is executed as a transaction, and rolls
                 * back if something goes wrong
                 */
                try
                {
                    // Start transaction
                    DB::query(NULL, 'BEGIN')->execute();

                    $user->create();
                    
                    $user->add('roles', array(
                        // “login” role required for login
                        Sprig::factory('role', array('name' => 'login'))->load(),
                        // “ängel” role required for forum
                        Sprig::factory('role', array('name' => 'ängel'))->load(),
                    ))->update();
                    
                    // Make invite invalid
                    $invite->values(array('invitee' => $user->id))->update();
                                        
                    // Commit transaction
                    DB::query(NULL, 'COMMIT')->execute();
                    
                    // Log in!
                    $this->auth->login($_POST['username'], $_POST['password']);
                    
                    // Welcome message and redirect to control panel
                    $this->message_add(sprintf(
                        'Välkommen, %s! Du är nu registrerad och inloggad.
                        Jag tog mig också friheten att dirigera dig till forumet.',
                        html::chars($user->username))); // TODO: Make message
                    
                    $this->request->redirect('forum', 303);
                }
                catch (Exception $e)
                {
                    // Rollback transaction (innodb ftw)
                    DB::query(NULL, 'ROLLBACK')->execute();
                    
                    // Non-validation errors are re-thrown and logged
                    if ( ! $e instanceof Validate_Exception)
                    {
                        throw $e;
                    }
                    
                    // Show validation errors
                    foreach ($e->array->errors('user/register') as $error)
                    {
                        $this->message_add($error, 'error');
                    }
                }
                
                $this->request->redirect($this->request->uri(), 303);
            }
            
            $this->template->content = View::factory('user/register')
                                       ->set('invite', $invite);
        }
    }

/* End of file user.php */
/* Location: ./application/classes/controller/user.php */ 