<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * @package     Änglarna STHLM
     * @author      Kim Burgestrand
     * @license     GNU GPLv3 http://www.gnu.org/licenses/gpl-3.0.txt
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
            
            $this->template->content = View::factory('user/recover');
        }
        
        /**
         * User view
         */
        public function action_view($user = NULL)
        {
            $this->template->content = $content = View::factory('user/view');
            $content->set('owner', FALSE);
            
            if (empty($user))
            {
                if ( ! $this->auth->logged_in())
                {
                    // TODO: show list of users
                    $this->message_add('Du är inte inloggad och kan därför inte se din profil');
                    $this->request->redirect_back();
                }
                
                $user = $this->auth->get_user()->username;
                $content->owner = TRUE;
            }
            
            $user = Model_User::factory($user)->load();
            $content->set('user', $user);
            
            $this->template->title = html::chars($user->username) . 's profil hos Änglarna Stockholm';
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
                }
            }
            
            $this->request->redirect_back();
        }
        
        /**
         * Registration procedure (from a given invitation)
         */
        public function action_register($token = NULL)
        {
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
                    $invite->values(array('invitee' => $user))->update();
                                        
                    // Commit transaction
                    DB::query(NULL, 'COMMIT')->execute();
                    
                    // Log in!
                    $this->auth->login($_POST['username'], $_POST['password']);
                    
                    // Welcome message and redirect to control panel
                    $this->message_add(sprintf(
                        'Välkommen, %s! Du är nu registrerad och inloggad.
                        Det här är din kontrollpanel där du kan ändra information
                        om ditt konto. Glöm inte att besöka det stängda forumet!',
                        html::chars($user->username))); // TODO: Make message
                    
                    $this->request->redirect('user/view', 303);
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
            }
            
            $this->template->content = View::factory('user/register')
                                       ->set('invite', $invite);
        }
    }

/* End of file user.php */
/* Location: ./application/classes/controller/user.php */ 