<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * A Username sprig field
     *
     * @package     Änglarna STHLM
     * @author      Kim Burgestrand
     * @license     http://www.gnu.org/licenses/gpl-3.0.txt
     */
    class Sprig_Field_Username extends Sprig_Field_Char
    {
        public $min_length = 2;
        public $max_length = 50;
        public $empty = FALSE;
        public $unique = TRUE;
    }
    
/* End of file username.php */
/* Location: ./application/classes/sprig/field/username.php */ 