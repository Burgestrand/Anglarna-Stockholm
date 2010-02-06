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
        
        /**
         * Loads the “Invite” model with the given primary key
         * 
         * @param primary key to load
         * @param dummy value to conform with Sprig
         * @return Model_Invite
         */
        public static function factory($token, array $dummy = array())
        {
            return parent::factory('invite', array('token' => $token));
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
            
            // 2, 3, 4
            $results = DB::select('*')
                       ->from($this->table())
                       ->where($this->pk(), '=', $token)
                       ->where('invitee', 'is', NULL)
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