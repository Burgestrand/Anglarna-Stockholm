<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * Post Model
     *
     * @package     Änglarna STHLM
     * @category    Models
     * @author      Kim Burgestrand
     * @license     http://www.fsf.org/licensing/licenses/agpl-3.0.html
     */
    class Model_Post extends Sprig
    {
        protected $_sorting = array('created' => 'desc');
        
        public function _init()
        {
            $this->_fields += array(
                'id' => new Sprig_Field_Auto,
                'forum' => new Sprig_Field_BelongsTo(array(
                    'model' => 'Forum',
                    'editable' => FALSE,
                    'empty' => FALSE,
                )),
                'user' => new Sprig_Field_BelongsTo(array(
                    'model' => 'User',
                    'empty' => TRUE,
                )),
                'author' => new Sprig_Field_Username,
                'ip' => new Sprig_Field_Ip(array(
                    'editable' => FALSE,
                )),
                'message' => new Sprig_Field_Char,
                'created' => new Sprig_Field_Datetime,
            );
        }
        
        public static function stylize($string)
        {
            return Markup::stylize($string);
        }
    }
    
/* End of file post.php */
/* Location: ./application/classes/model/post.php */ 
