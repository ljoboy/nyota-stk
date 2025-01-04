<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Africa/Kinshasa');


$host = $_SERVER['HTTP_HOST'];
$protocol = is_https() ? "https://" : "http://";

if (is_cli()) {
    $config['base_url'] = "";
} else if (stristr($host, "localhost") !== FALSE || (stristr($host, "192.168.") !== FALSE) || (stristr($host, "127.0.0.") !== FALSE)) {
    $config['base_url'] = $protocol . $host . "/";
} else {
    $allowed = [];

    $config['base_url'] = in_array($host, $allowed) ? $protocol . $host . "/" : $protocol . $_SERVER['HTTP_HOST'] . "/";
}

$config['index_page'] = '';

$config['uri_protocol'] = 'REQUEST_URI';

$config['url_suffix'] = '.html';

$config['language'] = 'french';

$config['charset'] = 'UTF-8';

$config['enable_hooks'] = FALSE;

$config['subclass_prefix'] = 'MY_';

$config['composer_autoload'] = FALSE;

$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';

$config['allow_get_array'] = TRUE;
$config['enable_query_strings'] = FALSE;
$config['controller_trigger'] = 'c';
$config['function_trigger'] = 'm';
$config['directory_trigger'] = 'd';

$config['log_threshold'] = 1;

$config['log_path'] = '';

$config['log_file_extension'] = '';

$config['log_file_permissions'] = 0644;

$config['log_date_format'] = 'Y-m-d H:i:s';

$config['error_views_path'] = '';

$config['cache_path'] = '';

$config['cache_query_string'] = FALSE;

$config['encryption_key'] = hex2bin('4a7573746520756e20656e6372797074696f6e206b657920666f727420706f75722073746b206d616e6167656d656e74');

$config['sess_driver'] = 'files';
$config['sess_cookie_name'] = '_stkmgmnt_sess__';
$config['sess_expiration'] = 60 * 30;
$config['sess_save_path'] = BASEPATH . 'sessions';
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 60;
$config['sess_regenerate_destroy'] = FALSE;

$config['cookie_prefix'] = '_stkmgmnt__';
$config['cookie_domain'] = '';
$config['cookie_path'] = '/';
$config['cookie_secure'] = FALSE;
$config['cookie_httponly'] = TRUE;

$config['standardize_newlines'] = TRUE;

$config['global_xss_filtering'] = FALSE;

$config['csrf_protection'] = FALSE;
$config['csrf_token_name'] = 'csrf_stkmgmnt__';
$config['csrf_cookie_name'] = 'csrf_stkmgmnt_cookie__';
$config['csrf_expire'] = 7200;
$config['csrf_regenerate'] = TRUE;
$config['csrf_exclude_uris'] = array();

$config['compress_output'] = FALSE;

$config['time_reference'] = 'Africa/Kinshasa';

$config['rewrite_short_tags'] = FALSE;

$config['proxy_ips'] = '';
