<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * Simplified class for markup parsing
     *
     * @package     Änglarna STHLM
     * @author      Kim Burgestrand
     * @license     http://www.fsf.org/licensing/licenses/agpl-3.0.html
     */
    class Markup
    {
        /**
         * Applies all applicable markup stylings in proper ording
         * 
         * @param string
         * @return string
         */
        public static function stylize($text)
        {
            $text = self::chars($text);
            $text = self::inlines($text);
            $text = self::links($text);
            $text = self::paragraphs($text);
            
            return $text;
        }
        
        /**
         * Converts special HTML characters to their HTML entities
         * 
         * NOTE: Is NOT safe for use in arguments! (ENT_NOQUOTES)
         * 
         * @param string
         * @return string
         */
        public static function chars($text)
        {
            return htmlspecialchars($text, ENT_NOQUOTES, 'utf-8');
        }
        
        /**
         * Finds links in a text and converts them to anchors
         * 
         * @param string
         * @return string
         */
        public static function links($text)
        {
            $text = preg_replace_callback('#"([^"]+)":"([^"]+)"#', array('Markup', 'anchors'), $text);
            $text = text::auto_link($text);

            return $text;
        }
        
        /**
         * private helper method for converting links to anchors
         * 
         * 
         */
        private static function anchors($match)
        {
            return html::anchor(html::chars($match[2]), html::chars($match[1]));
        }
        
        /**
         * Markdown-style paragraph converter
         * 
         * @param string
         * @return string
         */
        public static function paragraphs($text)
        {
            return str_replace('<br />', '', text::auto_p($text));
        }
        
        /**
         * Finds inline-blocks (strong, em, code) and htmlifies them
         * 
         * @param string
         * @return string
         */
        public static function inlines($text)
        {
            $delims = array(
                array('*', '<strong>\1</strong>'),
                array('_', '<em>\1</em>'),
                array('`', '<code>\1</code>')
            );
            
            foreach ($delims as $delim)
            {
                list($delim, $replacement) = $delim;
                $delim = preg_quote($delim);
                $pattern = "#
                    (?<=\p{^L}|\A)
                    {$delim}
                    ((?>[^{$delim}]+|{$delim}\p{L}+))
                    {$delim}
                    (?=\p{^L}|\z)#ux";
                $text = preg_replace($pattern, $replacement, $text);
            }
            
            return $text;
        }
    }
    
/* End of file markup.php */
/* Location: ./application/classes/markup.php */ 