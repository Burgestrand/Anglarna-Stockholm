<?php defined('SYSPATH') or die ('No direct script access.');
    /**
     * User Model
     *
     * @package     Änglarna STHLM
     * @author      Kim Burgestrand
     * @license     http://www.gnu.org/licenses/gpl-3.0.txt
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
        
        /**
         * Overloads “has_role” to always return true if user has “admin”
         *
         * @param string | role
         * @return boolean
         */
        public function has_role($role)
        {
            return parent::has_role('admin') || parent::has_role($role);
        }
    }
    
/* End of file user.php */
/* Location: ./application/classes/model/user.php */ 