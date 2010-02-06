<?php defined('SYSPATH') or die ('No direct script access.');
    /**
     * User Model
     *
     * @package     Änglarna STHLM
     * @author      Kim Burgestrand
     * @license     GNU GPLv3 http://www.gnu.org/licenses/gpl-3.0.txt
     */
    class Model_User extends Model_Auth_User
    {
        protected function _init()
        {
            parent::_init();
            $this->_fields += array(
                'invites' => new Sprig_Field_HasMany(array(
    				'model' => 'Invite',
    				'column' => 'inviter',
    			)),
            );
            
            // Fix fields
            $username = $this->_fields['username'];
            $username->min_length = 2;
            $username->max_length = 50;
            $username->rules = array();
            
            $email = $this->_fields['email'];
            $email->column = 'e-mail';
            $email->max_length = 255;
            
            unset($this->_fields['password_confirm']);
        }
    }
    
/* End of file user.php */
/* Location: ./application/classes/model/user.php */ 