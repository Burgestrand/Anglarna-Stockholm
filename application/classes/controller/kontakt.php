<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * @package     Änglarna STHLM
     * @author      Kim Burgestrand
     * @license     http://www.fsf.org/licensing/licenses/agpl-3.0.html
     */
    class Controller_Kontakt extends Template_Controller
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
                        $from['e-mail'] = 'svara-inte@anglarna.se';
                    }
                    
                    $sent = Email::send('stockholm@anglarna.se', // till
                                        array($from['e-mail'], $from['name']), // från
                                        '[Änglarna Stockholm] Meddelande från kontaktsidan',
                                        $message, TRUE);
                    
                    if ($sent >= 1)
                    {
                        $this->message_add('Ditt meddelande har skickats till ' . html::mailto('stockholm@anglarna.se') . '!');
                    }
                    else
                    {
                        $this->message_add('Något blev fel. Försök igen eller skicka ett vanligt mail till ' . html::mailto('stockholm@anglarna.se') . ' istället.', 'error');
                    }
                }
                else
                {
                    $this->message_add('Du måste ange ett meddelande.', 'error');
                }
                
                $this->request->reload();
            }
            
            $this->template->title = 'Kontakta Änglarna Stockholm';
            $this->template->content = View::factory('kontakt/index');
        }
    }
    
/* End of file kontakt.php */
/* Location: ./application/classes/controller/kontakt.php */ 
