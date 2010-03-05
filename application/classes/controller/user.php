<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * @package     Änglarna STHLM
     * @author      Kim Burgestrand
     * @license     http://www.fsf.org/licensing/licenses/agpl-3.0.html
     */
    class Controller_User extends Controller_Template
    {
        public function action_index()
        {
            if ( ! $this->auth->logged_in())
            {
                $this->request->redirect('/');
            }
            else
            {
                $user = $this->auth->get_user();
                
                if ($_POST)
                {
                    $values = arr::extract($_POST, array('email', 'password'), NULL);
                    $values = array_filter($values, create_function('$x', 'return ! empty($x);'));
                    
                    /**
                     * We have huge problems here:
                     * - $user->check() throws exception if $user->email is the same (since it is not unique)
                     * - $user->values($values) sets values but does not rollback if update() throws exception
                     * - clone $user does not update $user in session if update is successfull
                     * - if $user is updated after update (using values); session user changed() array is forever set
                     * 
                     * Solution: remove email if its’ the same as the current email (to avoid unique exception)
                     */
                    if ($values['email'] === $user->email)
                    {
                        unset($values['email']);
                    }
                    
                    try
                    {
                        // Update user
                        $user->values($user->check($values))->update();
                        $this->message_add('Din användare har uppdaterats.');
                    }
                    catch (Validate_Exception $e)
                    {
                        foreach ($e->array->errors('user/index') as $message)
                        {
                            $this->message_add($message, 'error');
                        }
                    }
                    
                    $this->request->reload();
                }
                
                $this->template->title = 'Information om ' . html::chars($user->username);
                $this->template->content = View::factory('user/index')->set('user', $user);
            }
        }
        
        /**
         * Recover a lost password
         */
        public function action_recover()
        {
            if ($this->auth->logged_in())
            {
                $this->request->redirect('user');
            }
                  
            if ( ! empty($_POST))
            {
                $email = arr::get($_POST, 'e-mail', '');
                $user = Sprig::factory('user', array('email' => $email))->load();
                
                if ($user->loaded())
                {
                    // Create a new token
                    $token = Sprig::factory('user_recover', array(
                        'token' => sha1(uniqid('user-recover')),
                        'user' => $user->id,
                        'expires' => time() + 60 * 60, // one hour
                    ))->create();
                    
                    // E-Mail information
                    $email = View::factory('email/recover')
                                 ->set('url', url::site("user/recover?token={$token->token}", TRUE));
                                 
                    // Send the e-mail!
                    Email::send($user->email, 
                                'stockholm@anglarna.se', 
                                '[Änglarna Stockholm] Återställning av konto',
                                (string)$email, TRUE);
                    
                    // Information
                    $this->message_add('Instruktioner om hur du återställer ditt konto har skickats till ' 
                                       . html::chars($user->email) . '!');
                }
                else
                {
                    $this->message_add(sprintf('Det finns inget konto registrerat till %s', html::chars($email)), 'error');
                }
                
                $this->request->redirect_back('/', 303);
            }
            elseif ( ! empty($_GET['token']))
            {
                // Load token
                $token = Sprig::factory('user_recover', array('token' => $_GET['token']))->load();
                
                if ($token->loaded() && gmdate('Y-m-d H:i:s') < $token->expires)
                {
                    // Force login user
                    $this->auth->force_login($token->user->load());
                    
                    // Delete token
                    $token->delete();
                    
                    // Redirect to control panel
                    $this->message_add('Du är nu inloggad. Glöm inte att byta lösenord!');
                    $this->request->redirect('user', 303);
                }
                else
                {
                    $this->message_add('Aktiveringslänken är felaktig eller för gammal.', 'error');
                }
            }
            
            $this->template->title = 'Återställning av användarkonto';
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
                             ->set('url', url::site("user/register?token={$invite->token}", true));
                    
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
            $this->request->redirect_back();
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
                        sprintf('Om du har glömt ditt lösenord kan vi hjälpa dig ' 
                                . html::anchor('user/recover', 'skaffa ett nytt lösenord') . '!'));
                }
            }
            
            $this->request->redirect_back();
        }
        
        /**
         * Registration procedure (from a given invitation)
         */
        public function action_register()
        {
            $token = arr::get($_GET, 'token', NULL);
            
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
                
                $this->request->reload();
            }
            
            $this->template->content = View::factory('user/register')
                                       ->set('invite', $invite);
        }
    }

/* End of file user.php */
/* Location: ./application/classes/controller/user.php */ 
