<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * User recovery tokens
     *
     * @package     Änglarna STHLM
     * @author      Kim Burgestrand
     * @license     http://www.fsf.org/licensing/licenses/agpl-3.0.html
     */
    class Model_User_Recover extends Sprig
    {
        protected $_table = 'user_recover';
        
        public function _init()
        {
            $this->_fields += array(
                'token' => new Sprig_Field_Char(array(
                    'primary' => TRUE,
                    'unique' => TRUE,
                    'empty' => FALSE,
                )),
                'user' => new Sprig_Field_BelongsTo(array(
                    'model' => 'User',
                )),
                'expires' => new Sprig_Field_Datetime,
            );
        }
        
        // Extend common functions to garbage collect
        public function create()
        {
            $this->gc();
            return parent::create();
        }
        
        public function load(Database_Query_Builder_Select $query = NULL, $limit = 1)
        {
            $this->gc();
            return parent::load($query, $limit);
        }
        
        public function update()
        {
            $this->gc();
            return parent::update();
        }
        
        /**
         * Garbage collect all expired tokens (1% chance / page load)
         */
        public function gc()
        {
            static $run = FALSE;
            
            if (mt_rand(1, 100) == 1 && ! $run)
            {
                DB::delete('user_recover')->where('expires', '<=', gmdate('Y-m-d H:i:s'))->execute();
            }
            
            $run = TRUE;
            
            return $this;
        }
    }
    
/* End of file recover.php */
/* Location: ./application/classes/model/user/recover.php */ 
