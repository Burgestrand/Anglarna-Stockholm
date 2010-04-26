<?php defined('SYSPATH') or die ('No direct script access.');
    /**
     * User Model
     *
     * @package     Änglarna STHLM
     * @category    Models
     * @author      Kim Burgestrand
     * @license     http://www.fsf.org/licensing/licenses/agpl-3.0.html
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
            $this->_fields['username'] = new Sprig_Field_Username(array(
                'empty' => FALSE,
                'unique' => TRUE,
            ));
            
            $email = $this->_fields['email'];
            $email->column = 'e-mail';
            $email->max_length = 255;
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
