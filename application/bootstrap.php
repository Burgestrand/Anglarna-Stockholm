<?php defined('SYSPATH') or die('No direct script access.');

    //-- Environment setup --------------------------------------------------------
    
    /**
     * Set the default time zone.
     *
     * @see  http://docs.kohanaphp.com/features/localization#time
     * @see  http://php.net/timezones
     */
    date_default_timezone_set('Europe/Stockholm');
    
    /**
    * Set the default locale.
    *
    * @see http://docs.kohanaphp.com/about.configuration
    * @see http://php.net/setlocale
    */
    setlocale(LC_ALL, 'en_US.utf-8');
    
    /**
     * Enable the Kohana auto-loader.
     *
     * @see  http://docs.kohanaphp.com/features/autoloading
     * @see  http://php.net/spl_autoload_register
     */
    spl_autoload_register(array('Kohana', 'auto_load'));
    
    /**
     * Enable the Kohana auto-loader for unserialization.
     *
     * @see  http://php.net/spl_autoload_call
     * @see  http://php.net/manual/var.configuration.php#unserialize-callback-func
     */
    ini_set('unserialize_callback_func', 'spl_autoload_call');
    
    //-- Configuration and initialization -----------------------------------------
    
    /**
     * Set the development status
     */
    define('IN_DEVELOPMENT', $_SERVER['SERVER_NAME'] === 'localhost');
    
    /**
     * Sets the sites’ language
     */
    i18n::$lang = 'sv-se';
    
    /**
     * Initialize Kohana, setting the default options.
     *
     * The following options are available:
     *
     * - string   base_url    path, and optionally domain, of your application   NULL
     * - string   index_file  name of your index file, usually "index.php"       index.php
     * - string   charset     internal character set used for input and output   utf-8
     * - string   cache_dir   set the internal cache directory                   APPPATH/cache
     * - boolean  errors      enable or disable error handling                   TRUE
     * - boolean  profile     enable or disable internal profiling               TRUE
     * - boolean  caching     enable or disable internal caching                 FALSE
     */
    Kohana::init(array(
        'base_url'   => '/',
        'index_file' => '',
        'profiling'  => IN_DEVELOPMENT,
        'caching'    => ! IN_DEVELOPMENT
    ));
    
    /**
     * Attach the file write to logging. Multiple writers are supported.
     */
    Kohana::$log->attach(new Log_File(APPPATH.'logs'));
    
    /**
     * Attach a file reader to config. Multiple readers are supported.
     */
    Kohana::$config->attach(new Kohana_Config_File);
    
    /**
     * Enable modules. Modules are referenced by a relative or absolute path.
     */
    Kohana::modules(array(
        'database'   => MODPATH.'database',   // Database access
        'sprig'      => MODPATH.'sprig',      // Sprig ORM
        'sprig-auth' => MODPATH.'sprig-auth',
        'auth'       => MODPATH.'auth',
        'userguide'  => MODPATH.'userguide',  // User guide and API documentation
        'kogitlog'   => MODPATH.'kogitlog',   // Changelog
        'template'   => MODPATH.'template',   // Controller template and view examples
        ));
    
    /**
     * Set the routes. Each route must have a minimum of a name, a URI and a set of
     * defaults for the URI.
     */
    Route::set('error', 'error(/<status>)', array('status' => '\d{3}'))
        ->defaults(array(
            'controller' => 'error',
            'action'     => 'error',
            'status'     => 500,
        ));
    
    Route::set('default', '(<controller>(/<action>(/<id>)))')
        ->defaults(array(
            'controller' => 'index',
        ));
    
    /**
     * Execute the main request. A source of the URI can be passed, eg: $_SERVER['PATH_INFO'].
     * If no source is specified, the URI will be automatically detected.
     */
    try
    {
        $request = Request::instance($_SERVER['REQUEST_URI'])->execute();
    }
    catch (Exception $e)
    {
        if (IN_DEVELOPMENT)
           throw $e;
        
        if ($e instanceof Kohana_Request_Exception)
        {
            // No route has matched, just 404 it
            $request = Request::factory('error/404')->execute();
        }
        else
        {
            // Unknown error. Log it and fall back to a 404.
            Kohana::$log->add(Kohana::ERROR, $e);
            $request = Request::factory('error/404')->execute();
        }
    }
    
    /**
     * Show memory usage and execution time.
     */
    if ($request->send_headers()->response)
    {
        // Get the total memory and execution time
        $total = array(
            '{memory_usage}' => number_format((memory_get_peak_usage() - KOHANA_START_MEMORY) / 1024, 2).'KB',
            '{execution_time}' => number_format(microtime(TRUE) - KOHANA_START_TIME, 5).' seconds');
        
        // Insert the totals into the response
        $request->response = str_replace(array_keys($total), $total, $request->response);
    }
    
    
    /**
     * Display the request response.
     */
    echo $request->response;