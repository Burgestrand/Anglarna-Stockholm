<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * Invite Model
     *
     * @package     Änglarna STHLM
     * @category    Models
     * @author      Kim Burgestrand
     * @license     http://www.fsf.org/licensing/licenses/agpl-3.0.html
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
                    ),
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
        
        /**
         * Loads the “Invite” model with the given primary key
         * 
         * @param primary key to load
         * @param dummy value to conform with Sprig
         * @return Model_Invite
         */
        public static function factory($token, array $dummy = array())
        {
            if (Model_Invite::valid($token))
            {
                $dummy['token'] = $token;
            }
            
            return parent::factory('invite', $dummy);
        }
        
        /**
         * Checks the given invitation token for validity
         * 
         * Returns TRUE if, and only if, the following is confirmed:
         * 1. is a SHA1 hash
         * 2. exists in the database
         * 3. is unique
         * 4. has not been used up (nobody been registered using this yet)
         * 
         * @param token
         * @return boolean
         */
        public static function valid($token)
        {
            // 1
            if ( ! preg_match('#\A[0-9a-f]{40}\z#', $token))
            {
                return FALSE;
            }
            
            // Get object values
            $object = Model_Invite::factory(NULL);
            
            // 2, 3, 4
            $results = DB::select('*')
                       ->from($object->table())
                       ->where($object->pk(), '=', $token)
                       ->where('invitee', 'is', NULL)
                       ->execute()
                       ->count();
            
            if ($results !== 1)
            {
                return FALSE;
            }
            
            return TRUE;
        }
    }
    
/* End of file invite.php */
/* Location: ./application/classes/model/invite.php */ 
