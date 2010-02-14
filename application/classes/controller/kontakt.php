<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * @package     Änglarna STHLM
     * @author      Kim Burgestrand
     * @license     http://www.gnu.org/licenses/gpl-3.0.txt
     */
    class Controller_Kontakt extends Controller_Template
    {
        public function action_index()
        {
            if ($_POST)
            {
                $message = html::chars((string)arr::get($_POST, 'message', ''));

                if ($message)
                {
                    // Append user information
                    if (($user = $this->auth->get_user()))
                    {
                        $message .= '<h2>Användarinfo</h2>';
                        $message .= '<dl>';
                        foreach (array('id', 'username', 'email') as $field)
                        {
                            $message .= sprintf('<dt>%s</dt><dd>%s</dd>', $field, html::chars($user->{$field}));
                        }
                        $message .= '</dl>';
                    }
                    
                    $from = arr::extract($_POST, array('e-mail', 'name'));
                    if ( ! Validate::email($from['e-mail']))
                    {
                        $from['name'] .= " ({$from['e-mail']})";
                        $from['e-mail'] = 'kim@burgestrand.se';
                    }
                    
                    $sent = Email::send('kim@burgestrand.se', // till
                                        array($from['e-mail'], $from['name']), // från
                                        '[Änglarna Stockholm] Meddelande',
                                        $message, TRUE);
                    
                    if ($sent >= 1)
                    {
                        $this->message_add('Ditt meddelande har skickats till webmaster!');
                    }
                    else
                    {
                        $this->message_add('Något blev fel. Försök igen eller skicka till ' . html::mailto('stockholm@anglarna.se') . ' istället.', 'error');
                    }
                }
                else
                {
                    $this->message_add('Du måste ange ett meddelande.', 'error');
                }
                
                $this->request->redirect('kontakt', 303);
            }
            
            $this->template->content = View::factory('kontakt/index');
        }
    }
    
/* End of file kontakt.php */
/* Location: ./application/classes/controller/kontakt.php */ 