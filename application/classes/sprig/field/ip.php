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
        public $rules = array('ip' => NULL);
        
        // public function value($value)
        // {
        //     return inet_ntop(parent::value($value));
        // }
    }
    
/* End of file ip.php */
/* Location: ./application/classes/sprig/field/ip.php */ 