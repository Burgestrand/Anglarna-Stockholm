<?php defined('SYSPATH') OR die('No direct access allowed.');
    
    /**
     * Gallery modeled to the same api as Sprig (file based currently)
     *
     * @package     Änglarna STHLM
     * @category    Models
     * @author      Kim Burgestrand
     * @license     http://www.fsf.org/licensing/licenses/agpl-3.0.html
     */
    class Model_Gallery
    {
        private static $_root;
        
        public static function factory($path = NULL, array $values = array())
        {
            if ( ! Model_Gallery::$_root)
            {
                Model_Gallery::$_root = DOCROOT . 'galleri';
            }
            
            if ( ! is_null($path))
            {
                $values['path'] = $path;
            }
            
            $obj = new Model_Gallery();
            foreach ($values as $key => $value)
            {
                $obj->{$key} = $value;
            }
            
            return $obj;
        }
        
        /**
         * Load all galleries
         */
        public function load($query = NULL, $limit = 1)
        {
            if ( ! empty($this->path))
            {
                // Resolve path
                $path = realpath(Model_Gallery::$_root . '/' . $this->path);
                
                // Make sure it's a gallery path
                if (strpos($path, Model_Gallery::$_root) !== 0)
                {
                    return (object) array('images' => array());
                }
                
                // Load ALL images
                $images = array();
                foreach (preg_grep('#(?<!_thumb)\.jpg#', glob($path . '/*.jpg')) as $image)
                {
                    $image = str_replace(dirname(Model_Gallery::$_root), '', $image);
                    $name  = basename($image, '.jpg');
                    $thumb = str_replace($name, $name . '_thumb', $image);
                    
                    $images[] = (object) array(
                        'alt'   => '',
                        'thumb' => basename($thumb),
                        'path'  => basename($image),
                    );
                }
                
                return (object) array('images' => $images);
            }
            else
            {
                // Load all galleries
                $dir  = new RecursiveDirectoryIterator(Model_Gallery::$_root);
                $iter = new RecursiveIteratorIterator($dir, RecursiveIteratorIterator::LEAVES_ONLY);
                $iter = iterator_to_array($iter);
                
                $paths = array();
                
                // Find only galleries
                foreach (array_keys($iter) as $path)
                {
                    if ( ! is_dir($path) && ! preg_match('#_thumb\.jpg#', $path))
                    {
                        $path = str_replace(Model_Gallery::$_root, '', dirname($path));
                        
                        if ($path)
                        {
                            $gallery =& $paths[$path];
                            $gallery = empty($gallery) ? 1 : $gallery + 1;
                        }
                    }
                }
                
                uksort($paths, create_function('$a, $b', 'return -strnatcasecmp($a, $b);'));
                
                $tmp = array();
                foreach ($paths as $path => $count)
                {
                    $tmp[] = (object) array(
                        'path'   => $path,
                        'images' => $count,
                    );
                }
                
                return $tmp;
            }
        }
    }
    
/* End of file gallery.php */
/* Location: ./application/classes/model/gallery.php */ 