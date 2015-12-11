<?php

class User extends Model {
    public function getUserByLogin($login) {
        $login = $this->db->escape($login);
        $sql = "select * from users where login = '{$login}' limit 1";
        $result = $this->db->query($sql);
        if (isset($result[0])) {
            return $result[0];
        }
        return false;
    }

    public function changeUserPassword($login, $new_password) {
        $login = $this->db->escape($login);
        $new_password = $this->db->escape($new_password);
        $hash = md5(Config::get('salt').$new_password);
        $sql = "update users
                        set
                            pass = '{$hash}'
                        where
                            login = '{$login}'
                   ";
        return $this->db->query($sql);
    }
}