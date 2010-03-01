<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * Forum Model
     *
     * @package     Änglarna STHLM
     * @author      Kim Burgestrand
     * @license     http://www.fsf.org/licensing/licenses/agpl-3.0.html
     */
    class Model_Forum extends Sprig
    {
        public function _init()
        {
            $this->_fields += array(
                'id' => new Sprig_Field_Auto,
                'name' => new Sprig_Field_Char(array(
                    'unique' => TRUE,
                    'max_length' => 30,
                )),
                'description' => new Sprig_Field_Char(array(
                    'max_length' => 255,
                )),
                'roles' => new Sprig_Field_ManyToMany(array(
                    'model' => 'Role',
                    'through' => 'forums_roles',
                )),
                'posts' => new Sprig_Field_HasMany(array(
                    'model' => 'Post',
                )),
            );
        }
    }
    
/* End of file forum.php */
/* Location: ./application/classes/model/forum.php */ 
