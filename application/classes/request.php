<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * An extension of the Request object
     *
     * @package     Änglarna STHLM
     * @author      Kim Burgestrand
     * @license     http://www.fsf.org/licensing/licenses/agpl-3.0.html
     */
    class Request extends Kohana_Request
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
            // Referrer within GET parameters?
            $referrer = arr::get($_GET, 'referrer', NULL);
            
            // Try the HTTP referrer
            if ( ! $referrer)
            {
                $referrer = Request::$referrer;
            }
            
            // Finally… default referrer
            if ( ! $referrer)
            {
                $referrer = $default;
            }
            
            $this->redirect(trim(parse_url($referrer, PHP_URL_PATH), '/'), $code);
        }
        
        /**
         * Redirect to current page (basically a page refresh)
         * 
         * This is useful when you POST data to a page and want to be
         * able to refresh it without resending it.
         * 
         * @param code HTTP status code (default: 303)
         * @return void
         */
        public function reload($code = 303)
        {
            $this->redirect($this->uri(), $code);
        }
    }

/* End of file request.php */
/* Location: ./application/classes/request.php */ 
