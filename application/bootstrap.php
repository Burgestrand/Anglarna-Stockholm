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
    i18n::$lang = 'en-us';
    
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
    Kohana::$log->attach(new Kohana_Log_File(APPPATH.'logs'));
    
    /**
     * Attach a file reader to config. Multiple readers are supported.
     */
    Kohana::$config->attach(new Kohana_Config_File);
    
    /**
     * Enable modules. Modules are referenced by a relative or absolute path.
     */
    Kohana::modules(array(
        // Database
        'database'   => MODPATH.'database',   // Database access
        'orm'        => MODPATH.'orm',        // Object Relationship Mapping
        'auth'       => MODPATH.'auth',       // Basic authentication
        
        // Misc
        'pagination' => MODPATH.'pagination', // Paging of results
        'userguide'  => MODPATH.'userguide',  // User guide and API documentation
        'codebench'  => MODPATH.'codebench',  // Benchmarking tool
        
        // Changelog
        'koglip'     => MODPATH.'koglip',
        'kogitlog'   => MODPATH.'kogitlog',  // changelog view
        ));
    
    /**
     * Set the routes. Each route must have a minimum of a name, a URI and a set of
     * defaults for the URI.
     */
    Route::set('default', '(<controller>(/<action>(/<id>)))')
        ->defaults(array(
            'controller' => 'index',
            'action'     => 'index',
        ));
    
    /**
     * Execute the main request. A source of the URI can be passed, eg: $_SERVER['PATH_INFO'].
     * If no source is specified, the URI will be automatically detected.
     */
    $request = Request::instance();
    
    try
    {
        $request->execute();
    }
    catch (Exception $e)
    {
        if (IN_DEVELOPMENT)
            throw $e;
        
        // Log the error
        Kohana::$log->add(Kohana::ERROR, Kohana::exception_text($e));
        
        // Create a 404 response
        $request->status   = 404;
        $request->response = View::factory('errors/template')
                           ->set('title', '404 :: *placeholder*')
                           ->set('content', View::factory('errors/404'));
    }
    
    if ($request->send_headers()->response)
    {
        // Post-modify response
        // $request->response = str_replace(array(), array(), $request->response);
    }
    
    /**
     * Display request response
     */
    echo $request->response;