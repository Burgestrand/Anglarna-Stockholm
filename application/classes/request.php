<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * An extension of the Request object
     *
     * @package     Änglarna STHLM
     * @author      Kim Burgestrand
     * @license     http://www.gnu.org/licenses/gpl-3.0.txt
     */
    class Request extends Kohana_Request
    {
        /**
         * Redirects the user back to where they came from
         * 
         * If the referring page cannot be found it falls back to the
         * default, specified in the first parameter.
         * 
         * @param default
         * @param code HTTP status code (default: 303)
         * @return void
         */
        public function redirect_back($default = '/', $code = 303)
        {
            if (empty(Request::$referrer))
            {
                $this->redirect($default, $code);
            }
            else
            {
                $this->redirect(Request::$referrer, $code);
            }
        }
    }

/* End of file request.php */
/* Location: ./application/classes/request.php */ 