<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * @package     Änglarna STHLM
     * @author      Kim Burgestrand
     * @license     http://www.gnu.org/licenses/gpl-3.0.txt
     */
    abstract class Auth extends Kohana_Auth
    {
        /**
         * Returns true if the current user has *all* the given roles
         * (a user not logged is assumed to have no roles)
         * 
         * Note: if no roles are passed it always returns true
         *
         * @param  array|string… roles
         * @return boolean
         */
        public function has_roles($roles)
        {
            if ( ! is_array($roles))
            {
                $roles = (array) $roles;
            }
            
            $args = func_get_args();
            $roles = array_merge($roles, array_slice($args, 1));
            
            return empty($roles) ? TRUE 
                                 : call_user_func_array(array($this, 'logged_in'), 
                                                        $roles);
        }
    }
    
/* End of file auth.php */
/* Location: ./application/classes/auth.php */ 