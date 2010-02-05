<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * Invite Model
     *
     * @package     Änglarna STHLM
     * @author      Kim Burgestrand
     * @license     GNU GPLv3 http://www.gnu.org/licenses/gpl-3.0.txt
     */
    class Model_Invite extends Sprig
    {
        protected function _init()
        {
            $this->_fields += array(
                'token' => new Sprig_Field_Char(array(
                    'primary' => TRUE,
                    'unique' => TRUE,
                    'rules' => array(
                        'regex' => array('#\A[0-9a-f]{40}\z#'),
                    )
                )),
                'email' => new Sprig_Field_Email(array(
                    'unique' => TRUE,
                    'column' => 'e-mail',
                )),
                'inviter' => new Sprig_Field_BelongsTo(array(
                    'model' => 'User',
                    'column' => 'inviter',
                )),
                'invitee' => new Sprig_Field_BelongsTo(array(
                    'model' => 'User',
                    'column' => 'invitee',
                    'null' => TRUE,
                ))
            );
        }
    }
    
/* End of file invite.php */
/* Location: ./application/classes/model/invite.php */ 