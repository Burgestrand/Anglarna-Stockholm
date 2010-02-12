<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * Post Model
     *
     * @package     Änglarna STHLM
     * @author      Kim Burgestrand
     * @license     http://www.gnu.org/licenses/gpl-3.0.txt
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
    }
    
/* End of file post.php */
/* Location: ./application/classes/model/post.php */ 