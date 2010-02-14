<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * This is where all errors end up
     *
     * @package     Änglarna STHLM
     * @category    Controllers
     * @author      Kim Burgestrand <kim@burgestrand.se>
     * @license     http://www.gnu.org/licenses/lgpl-3.0.txt
     */
    class Controller_Error extends Controller_Template
    {
        public $template = 'error/template';
        public $suggestions = array();
        
        /**
         * Handles *all* errors.
         *
         * @return      void
         */
        public function action_error($status = NULL)
        {
            $this->template->content = View::factory("error/{$status}");
            
            /**
             * Suggestions as to where to go next
             */
            $this->template->bind('suggestions', $this->suggestions);
            
            // Back
            if (Request::$referrer)
            {
                $this->suggestions[] = html::anchor(Request::$referrer, __('Gå tillbaka dit du kom ifrån'));
            }
            
            // Root
            $this->suggestions[] = html::anchor('/', __('Börja om från början'));
            
            // Call possible extra function
            $extra = "extra_{$status}";
            if (is_callable(array($this, $extra)))
            {
                $this->$extra();
            }
        }
        
        public function extra_404()
        {
            array_unshift($this->suggestions,
                          html::anchor('http://google.com/search?q=site:'.$_SERVER['SERVER_NAME']
                                      .' '.strtr($_SERVER['REQUEST_URI'], '/', ' ')
                                      ,__('Försök att söka efter vad som kan ha varit här (via Google)')));
        }
        
        public function before()
        {
            parent::before();
            
            // Automatically set request status
            $status = $this->request->param('status', 500);
            if (isset(Request::$messages[$status]))
            {
                $this->request->status = $status;
            }
            
            // View variables
            $this->template->title = __(Request::$messages[$this->request->status]);
        }
    }
    
/* End of file error.php */
/* Location: ./application/classes/controller/error.php */ 