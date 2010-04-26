<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * Forum Model
     *
     * @package     Änglarna STHLM
     * @category    Models
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
        
        public static function factory($key, array $dummy = array())
        {
            $forum = parent::factory('forum');
            
            if ( ! empty($key))
            {
                $dummy = array($forum->unique_key($key) => $key) + $dummy;
            }
            
            return $forum->values($dummy);
        }
        
        /**
         * Fetch ONLY the forums where all roles are contained within the given parameter
         * 
         * @param array roles
         * @return Database_Result
         */
        public function fetch(array $roles = array())
        {
            // Compute roles clause
            empty($roles) AND $roles = array('');
            $roles = array_map(array(Database::instance(), 'escape'), $roles);
            $roles = implode(', ', $roles);
            $roles = DB::expr("({$roles})");
            
            // Target model
            $field = $this->field('roles');
            $model = Sprig::factory($field->model);
            
            // Find the proper forums
            $query = DB::select()
                ->join($field->through, 'LEFT')
                ->on($this->fk($field->through), '=', $this->pk(TRUE))
                ->join($model->table(), 'LEFT')->on($model->fk($field->through), '=', $model->pk(TRUE))
                                               ->on($model->pk(TRUE), 'NOT IN', $roles)
                ->group_by($this->pk(TRUE))
                ->having("COUNT(\"{$model->pk(TRUE)}\")", '=', 0);
            
            return Sprig::factory('forum')->load($query, 0);
        }
        
        public function unique_key($key)
        {
            return ctype_digit($key) ? 'id' : 'name';
        }
    }
    
/* End of file forum.php */
/* Location: ./application/classes/model/forum.php */ 
