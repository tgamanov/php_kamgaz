<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('VIEWS_PATH', ROOT.DS.'views');
define('AJAX_RESPONSE_VIEW', VIEWS_PATH.DS."responses".DS."ajax.php");

require_once(ROOT.DS.'lib'.DS.'init.php');

//error_reporting(0);
session_start();

try {
    App::run($_SERVER['REQUEST_URI']);
} catch (Exception $e) {
    if ($e instanceof ClassException || $e instanceof MethodException) {
        Router::redirect('/404.html');
    }elseif ($e instanceof TemplateException) {
    }elseif ($e instanceof LangException) {
        Session::setFlash('Мова тимчасово не доступна');
        Router::redirect('/');
    }elseif ($e instanceof DbException) {
        Session::setFlash('Помилка бази даних. Будь-ласка, спробуйте пізніше.');
        Router::redirect('/');
    }else {
        Session::setFlash('Помилка сервера. Будь-ласка, спробуйте пізніше.');
        Router::redirect('/');
    }
}