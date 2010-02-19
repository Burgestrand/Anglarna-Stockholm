<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * An IP-address sprig Field, stored in a 16-byte binary field
     *
     * @package     Änglarna STHLM
     * @author      Kim Burgestrand
     * @license     http://www.gnu.org/licenses/gpl-3.0.txt
     */
    class Sprig_Field_Ip extends Sprig_Field_Char
    {
        public $min_length = 4; // IPv4
        public $max_length = 16; // IPv6
        public $default = NULL;
        public $null = TRUE;
        
        public function value($value)
        {
            $value = parent::value($value);
            
            if (is_null($value))
            {
                return inet_pton(Request::$client_ip);
            }
            else
            {
                return Validate::ip($value) ? inet_pton($value) 
                                            : inet_ntop($value);
            }
        }
    }
    
/* End of file ip.php */
/* Location: ./application/classes/sprig/field/ip.php */ 