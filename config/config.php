<?php

Config::set('site_name', "Кам'янське управління експлуатації газового господарства");

Config::set('languages', array('ua'));

Config::set('routes', array(
    'default' => '',
    'admin'   => 'admin_',
    'api'   => 'api_',
));

Config::set('default_route', 'default');
Config::set('default_language', 'ua');
Config::set('default_controller', 'pages');
Config::set('default_action', 'index');

Config::set('db.host', 'localhost');
Config::set('db.user', 'root');
Config::set('db.password', 'pass');
Config::set('db.db_name', 'test');

Config::set('salt', 'h3u2i21j21kj123jqw');

Config::set('send_index_from_day', 25);

Config::set('api_error_wrong_user_data', 'error_wrong_user_data');
Config::set('api_error_early', 'error_early_'.Config::get('send_index_from_day'));
Config::set('api_index_received', 'index_received');
Config::set('api_no_data', 'no_data');