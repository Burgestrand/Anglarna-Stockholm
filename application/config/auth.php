<?php defined('SYSPATH') OR die('No direct access allowed.');

    return array(
        'driver' => 'ORM',
        'hash_method' => 'sha256',
        'salt_pattern' => '1, 3, 5, 7, 11, 13, 17, 19, 23, 31, 33',
        'lifetime' => 60 * 60 * 24 * 14, // remembered for two weeks
        'session_key' => 'auth_user',
    );

/* End of file auth.php */
/* Location: ./application/config/auth.php */ 