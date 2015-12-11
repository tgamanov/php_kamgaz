<?php

class View {
    protected $data;
    protected $path;

    function __construct($data = array(), $path = null)
    {
        if (!$path) {
            $path = self::getDefaultViewPath();
        }
        if (!file_exists($path)) {
            throw new TemplateException('Template file is not found in path: '.$path);
        }
        $this->path = $path;
        $this->data = $data;

    }

    protected static function getDefaultViewPath() {
        $router = App::getRouter();
        if (!$router) {
            throw new Exception('Router was not found');
        }
        $controller_dir = $router->getController();
        $template_name = $router->getMethodPrefix().$router->getAction().'.php';

        return VIEWS_PATH.DS.$controller_dir.DS.$template_name;
    }

    public function render() {
        $data = $this->data;

        ob_start();
        include($this->path);
        $content = ob_get_clean();

        return $content;
    }

}