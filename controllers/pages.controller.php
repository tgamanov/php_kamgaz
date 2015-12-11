<?php

class PagesController extends Controller {


    function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new News();
    }

    public function index() {
        $top_news =  $this->model->getTopNews();
        if (empty($top_news))
            $this->data['regular_news'] = $this->model->getRegularNews(5,0);
        $this->data['top_news'] = $top_news;


    }

    public function documents() {
    }

    public function contacts() {
    }

    public function admin_index() {

    }


}