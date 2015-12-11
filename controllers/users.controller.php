<?php


class UsersController extends Controller {

    function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new User();
    }

    function admin_login() {
        if (is_null(Session::get('user'))) {
            if ($_POST) {
                $login = isset($_POST['login']) ? $_POST['login'] : '';
                $login = htmlspecialchars($login);
                $password = isset($_POST['password']) ? $_POST['password'] : '';
                $password = htmlspecialchars($password);
                $hash = md5(Config::get('salt').$password);
                $user = $this->model->getUserByLogin($login);
                if ($user && $user['pass'] == $hash) {
                    Session::set('user', $login);
                    Router::redirect('/admin/');
                } else {
                    Session::setFlash('Wrong user data');
                }

            }
        } else {
            Router::redirect('/admin/');
        }

    }

    function admin_logout() {
        Session::delete('user');
        Router::redirect('/admin/users/login');
    }

    function admin_change () {
        if ($_POST && isset($_POST['old_password']) && isset($_POST['new_password']) && isset($_POST['repeat_password'])) {
            $login = Session::get('user');
            $old_password = isset($_POST['old_password']) ? $_POST['old_password'] : '';
            $old_password = htmlspecialchars($old_password);
            $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
            $new_password = htmlspecialchars($new_password);
            $repeat_password = isset($_POST['repeat_password']) ? $_POST['repeat_password'] : '';
            $repeat_password = htmlspecialchars($repeat_password);
            $hash = md5(Config::get('salt').$old_password);
            $user = $this->model->getUserByLogin($login);
            if ($user && $user['pass'] == $hash) {
                if($new_password == $repeat_password) {
                    if (strlen($new_password) >= 6) {
                        if (preg_match("#[0-9]+#",$new_password)) {
                            if (preg_match("#[a-zA-Z]+#",$new_password)) {
                                $this->model->changeUserPassword($login, $new_password);
                                Session::setFlash('Пароль змінено');
                            } else {
                                Session::setFlash('Пароль повинен містити не менш ніж 1 літеру!');
                            }
                        } else {
                            Session::setFlash('Пароль повинен містити не менш ніж 1 цифру!');
                        }
                    } else {
                        Session::setFlash('Пароль повинен містити не менш ніж 6 символів!');
                    }
                } else {
                    Session::setFlash('Не правильно повторено пароль!');
                }
            } else {
                Session::setFlash('Не правильний пароль!');
            }
        }
    }


}