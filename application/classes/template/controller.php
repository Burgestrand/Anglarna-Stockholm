<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * Depends on “template” submodule.
     * 
     * @package     Änglarna STHLM
     * @author      Kim Burgestrand
     * @license     http://www.fsf.org/licensing/licenses/agpl-3.0.html
     */
    class Template_Controller extends Koxtend_Controller_Template
    {
        /**
         * Initializes Session and Auth
         */
        public function before()
        {
            parent::before();
            $this->session = Session::instance();
            $this->auth    = Auth::instance();
            
            // Navigation links
            $links = array('start', 'forum', 'resor',
                           'arkiv', 'galleri', 'kontakt');
            
            foreach ($links as $i => $link)
            {
                // List-item attributes
                $attributes = $link == $this->request->controller 
                            ? array('class' => 'active')
                            : NULL;
                
                // Anchor parameters
                $anchor    = array(
                    url::site($link),
                    utf8::ucfirst($link)
                );
                
                $links[$i] = array($attributes,
                                   call_user_func_array(array('html', 'anchor'), $anchor));
            }
            
            // Template variables
            $template = $this->template;
            $template->navigation = View::factory('html/list', array(
                'attributes' => array('class' => 'nav site'),
                'items'      => $links,
                'ordered'    => FALSE,
            ));
            $template->sidebar    = View::factory('sidebar');
        }
        
        public function after()
        {
            if (empty($this->template->title))
            {
                $this->template->title = Kohana::message('titles', "{$this->request->controller}/{$this->request->action}");
            }
            
            return parent::after();
        }
    }
    
/* End of file template.php */
/* Location: ./application/classes/controller/template.php */ 
