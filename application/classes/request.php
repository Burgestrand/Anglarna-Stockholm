<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * An extension of the Request object
     *
     * @package     Änglarna STHLM
     * @author      Kim Burgestrand
     * @license     http://www.fsf.org/licensing/licenses/agpl-3.0.html
     */
    class Request extends Koxtend_Request
    {
        /**
         * Redirects the user back to where they came from
         * 
         * If the referring page cannot be found it falls back to the
         * default, specified in the first parameter.
         * 
         * It never redirects to an absolute URL, only relative ones.
         * 
         * @param default
         * @param code HTTP status code (default: 303)
         * @return void
         */
        public function redirect_back($default = '/', $code = 303)
        {
            if (Request::$referrer)
            {
                $default = Request::$referrer;
            }
            
            $referrer = arr::get($_GET, 'referrer', $default);
            
            $this->redirect($referrer, $code);
        }
    }

/* End of file request.php */
/* Location: ./application/classes/request.php */ 
