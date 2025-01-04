<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$autoload['packages'] = array();

$autoload['libraries'] = array('Genlib', 'database', 'email', 'session');

$autoload['drivers'] = array();

$autoload['helper'] = array('url', 'date', 'string', 'text');

$autoload['config'] = array();

$autoload['language'] = array('db','form_validation');

$autoload['model'] = array('genmod');
