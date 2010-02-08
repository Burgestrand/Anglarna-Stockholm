<?php defined('SYSPATH') OR die('No direct access allowed.');
    /**
     * Översättningar till felmeddelanden vid registrering.
     */
    return array(
        'username' => array(
            'unique' => 'Det användarnamnet är redan registrerat',
            'not_empty' => 'Du måste ha ett användarnamn',
            'min_length' => 'Ditt användarnamn måste vara minst :param1 tecken långt',
            'max_length' => 'Ditt användarnamn får inte vara större än :param1 tecken långt',
        ),
        'password' => array(
            'not_empty' => 'Du får inte ha ett tomt lösenord'
        ),
    );