<?php

class News extends Model {

    public function getRegularNews($limit, $start) {
        $limit = (int)$limit;
        $start = (int)$start;
        $sql = "select * from news where n_type = 0 order by n_date desc limit {$start}, {$limit} ";
        return $this->db->query($sql);
    }

    public function getTopNews() {
        $sql = "select * from news where n_type = 1 order by n_date desc";
        return $this->db->query($sql);
    }

    public function getById($id) {
        $id = $this->db->escape($id);
        $sql = "select * from news where id = {$id} limit 1";
        return $this->db->query($sql)[0];
    }

    public function getRegularCount() {
        $sql = "select count(*) from news where n_type = 0";
        return $this->db->query($sql)[0]['count(*)'];
    }

    public function getAllNews() {
        $sql = "select * from news order by n_type desc, n_date desc";
        return $this->db->query($sql);
    }

    public function deleteNewsById($id) {
        $id = (int)$id;
        $sql = "delete from news where id = {$id}";
        return $this->db->query($sql);
    }

    public function changeNews($id, $title, $description, $body, $type) {
        $id = (int)$id;
        $type = (int)$type;
        $title = $this->db->escape($title);
        $description = $this->db->escape($description);
        $body = $this->db->escape($body);
        $sql = "update news
                    set
                        n_title = '{$title}',
                        n_description = '{$description}',
                        n_body = '{$body}',
                        n_type = {$type}
                    where
                        id = {$id}
                        ";
        return $this->db->query($sql);
    }

    public function addNews($title, $description, $body, $type, $on_date) {
        $type = (int)$type;
        $title = $this->db->escape($title);
        $description = $this->db->escape($description);
        $body = $this->db->escape($body);
        $on_date = $this->db->escape($on_date);
        $sql = "insert into news
                    set
                        n_title = '{$title}',
                        n_description = '{$description}',
                        n_body = '{$body}',
                        n_type = {$type},
                        n_date = '{$on_date}'
                    ";
        return $this->db->query($sql);
    }
}