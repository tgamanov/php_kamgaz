<?php

require_once(ROOT.DS.'config'.DS.'config.php');

function __autoload($class_name) {
    $lib_path = ROOT.DS.'lib'.DS.strtolower($class_name).'.class.php';
    $controllers_path = ROOT.DS.'controllers'.DS.str_replace('controller', '', strtolower($class_name)).'.controller.php';
    $exception_path = ROOT.DS.'exceptions'.DS.str_replace('exception', '', strtolower($class_name)).'.exception.php';
    $model_path = ROOT.DS.'models'.DS.strtolower($class_name).'.php';

    if (file_exists($lib_path)) {
        require_once($lib_path);
    } elseif (file_exists($model_path)) {
        require_once($model_path);
    } elseif (file_exists($controllers_path)) {
        require_once($controllers_path);
    } elseif (file_exists($exception_path)) {
        require_once($exception_path);
    } else {
        throw new ClassException('Failed to include class '.$class_name);
    }
}

function __($key, $default_value) {
    return Lang::get($key, $default_value);
}


// define global function
function mb_ucfirst($text) {
    mb_internal_encoding("UTF-8");
    return mb_strtoupper(mb_substr($text, 0, 1)) . mb_strtolower(mb_substr($text, 1));
}