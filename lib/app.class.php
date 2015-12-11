<?php

class App {

    protected static $router;

    public static $db;



    public static function run($uri) {
        self::$router = new Router($uri);
        Lang::load(self::$router->getLanguage());

        self::$db = DB::getInstance();
//        if (self::$router->getRoute() == 'admin' && is_null(Session::get('user'))) {
//            self::$router->redirect('/admin/');
//        }
        if (self::$router->getController() == "favicon.ico") die;
//        $test = self::$router->getController();
//        echo $test."<br>";
//        $test = self::renameToSafeCall($test);
//        echo $test."<br>";

        $controller_class = ucfirst(self::$router->getController()).'Controller';
        $controller_method = strtolower(self::$router->getMethodPrefix().self::$router->getAction());

        if (self::$router->getRoute() == 'admin' && is_null(Session::get('user'))) {
            if(strtolower(self::$router->getAction()) != 'login') {
                Router::redirect('/admin/users/login');
            }
        }
            $controller_object = new $controller_class();
        if (method_exists($controller_object, $controller_method)) {
            $view_path = $controller_object->$controller_method();
            $view_object = new View($controller_object->getData(), $view_path);
            $content = $view_object->render();
        } else {
            throw new MethodException('Cannot run method '.$controller_method.' on class '.$controller_class);
        }

        $layout = self::$router->getRoute();
        $layout_path = VIEWS_PATH.DS.$layout.'.php';
        $array_content = array();
        $array_content['content'] = $content;
        // exception from rules for account_count
        if (isset( $controller_object->getData()['account_count'] )) {
            $array_content['account_count'] = $controller_object->getData()['account_count'];
        }
        $layout_view_object = new View($array_content, $layout_path);
        echo $layout_view_object->render();



    }

    /**
     * @return mixed
     */
    public static function getRouter()
    {
        return self::$router;
    }


}