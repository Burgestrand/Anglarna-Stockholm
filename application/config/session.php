<?php defined('SYSPATH') OR die('No direct access allowed.');

return array('native' => array(
                 'name'      => 'session_name', // ??
                 'encrypted' => true,
                 'lifetime'  => 60 * 90, // session valid 90 minutes
              ),
             'database' => array(
                 'group' => 'default', // database connection to use
                 'table' => 'sessions', // table to store session data in
             ));

/* End of file session.php */
/* Location: ./application/config/session.php */ 