<?php

class NewsController extends Controller {

    function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new News();
    }

    public function index() {
        $page = 1;
        $limit = 5;
//        if (isset($this->params_get['page'])) {
//            $page = (int) $this->params_get['page'];
//        }
        if (isset($_GET['page'])) {
            $page = (int) $_GET['page'];
        }
        $this->data['regular_news'] = $this->model->getRegularNews($limit,($page - 1) * $limit);
        $this->data['top_news'] = $this->model->getTopNews();
        $this->data['regular_news_count'] = $this->model->getRegularCount();
        $this->data['current_page'] = $page;
    }

    public function view() {
        if(isset($this->params[0])) {
            $news_id = (int)$this->params[0];
            $this->data['news'] = $this->model->getById($news_id);
        }
    }

    public function admin_index() {
        if($_POST) {
            if(isset($_POST['delete'])) {
                $id = isset($_POST['id']) ? $_POST['id'] : 0;
                $id = (int)$id;
                $this->model->deleteNewsById($id);
            } elseif(isset($_POST['change'])) {
                $id = isset($_POST['id']) ? $_POST['id'] : 0;
                $id = (int)$id;
                $title = isset($_POST['title']) ? $_POST['title'] : 0;
                $description = isset($_POST['description']) ? $_POST['description'] : 0;
                $body = isset($_POST['body']) ? $_POST['body'] : 0;
                $is_top = 0;
                if(isset($_POST['is_top'])) {
                    $is_top = 1;
                }
                $this->model->changeNews($id, $title, $description, $body, $is_top);

                Session::setFlash("Новина змінена!");

            } elseif(isset($_POST['add'])) {

                $title = isset($_POST['title']) ? $_POST['title'] : 0;
                $description = isset($_POST['description']) ? $_POST['description'] : 0;
                $body = isset($_POST['body']) ? $_POST['body'] : 0;
                $on_date = isset($_POST['on_date']) ? $_POST['on_date'] : date("Y-m-d");
                $is_top = 0;
                if(isset($_POST['is_top'])) {
                    $is_top = 1;
                }
                $this->model->addNews($title, $description, $body, $is_top, $on_date);
                Session::setFlash("Новина додана!");
            }
        }

        $this->data['news'] = $this->model->getAllNews();
    }
}