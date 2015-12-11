<?php

class PersonalController extends Controller {

    function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new Person();
    }

    private function registerPerson() {
        $this->data['account'] = $this->model->getByAccNumber(Session::get('person'));
        $this->data['account_data'] = $this->model->getDataList(Session::get('person'));
        $this->data['account_index'] = $this->model->getIndexList(Session::get('person'));
        $this->data['warning'] = $this->model->getWarning(Session::get('person'));
    }

    public function index() {
        if (is_null(Session::get('person'))) {
            if ($_POST) {
                $acc_number = isset($_POST['acc_number']) ? $_POST['acc_number'] : 0;
                $acc_number = (int) $acc_number;
                $acc_soname = isset($_POST['acc_soname']) ? $_POST['acc_soname'] : '';
                $acc_soname = htmlspecialchars($acc_soname);
                $account =  $this->model->getByAccNumber($acc_number);
                if ((mb_strtolower($account['acc_soname']) == mb_strtolower($acc_soname)) && ($acc_soname != '') && ($acc_number != 0) ){
                    Session::set('person', $acc_number);
                    $this->registerPerson();
                }
                else {
                    Session::setFlash("Не вірні дані!");
                }
            }
        } else {
            $this->registerPerson();
        }

    }

    public function logout() {
        if (!is_null(Session::get('person'))) {
            Session::delete('person');
        }
        Router::redirect('/personal/');
    }

    public function send() {

        if(!is_null(Session::get('person'))) {
            if($_POST) {
                $last_index = isset($_POST['last_index']) ? $_POST['last_index'] : 0;
                $last_index = htmlspecialchars($last_index);
                $last_index = (int)$last_index;
                if ($last_index <=0 ) {
                    Session::setFlash('Не правильний показник');
                } else {
                    if (date("d") < Config::get('send_index_from_day')) {
                        Session::setFlash('Передати показник лічильника станом на кінець місяця можна буде з '
                                            .Config::get('send_index_from_day')
                                            .' числа поточного місяця');
                    } else {
                        $this->model->saveIndex(Session::get('person'), $last_index, 'website');
                        Session::setFlash('Показник передано');
                    }
                }
            }
        }
        else {
            Session::setFlash('Авторизуйтеся в системі');
        }

        Router::redirect('/personal/');
    }

    public function warned() {
        if(!is_null(Session::get('person'))) {
            $this->model->deleteWarning(Session::get('person'));
        } else {
            Session::setFlash('Авторизуйтеся в системі');
        }
        Router::redirect('/personal');
    }

    public function admin_save() {
        if ($_POST) {
            $acc_number = isset($_POST['acc_number']) ? $_POST['acc_number'] : 0;
            $acc_number = (int)$acc_number;
            if ($acc_number <= 0) {
                $this->data['ajax_response'] = "Error: acc_number could not be lower than 0";
                return AJAX_RESPONSE_VIEW;
            }
            $soname = isset($_POST['soname']) ? $_POST['soname'] : '';
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            $middle_name = isset($_POST['middle_name']) ? $_POST['middle_name'] : '';
            $street = isset($_POST['street']) ? $_POST['street'] : '';
            $house = isset($_POST['house']) ? $_POST['house'] : '';
            $flat = isset($_POST['flat']) ? $_POST['flat'] : '';
            $acc_index = isset($_POST['acc_index']) ? $_POST['acc_index'] : 0;
            $acc_index = (int)$acc_index >= 0 ? (int)$acc_index : 0;
            $balance = isset($_POST['balance']) ? $_POST['balance'] : 0.0;
            $balance = doubleval($balance);
            $on_date = isset($_POST['on_date']) ? $_POST['on_date'] : date("Y-m-d");


            // TODO save data to DB
            $this->model->saveData($acc_number, $soname, $name, $middle_name, $street, $house, $flat, $acc_index, $balance, $on_date);
            $this->data['ajax_response'] = "ok";
        } else {
            $this->data['ajax_response'] = "Need POST data to use this url";
        }
        return AJAX_RESPONSE_VIEW;
    }

    public function  admin_delete() {
        if($_POST && isset($_POST['delete_on_date'])){
            $delete_on_date = $_POST['delete_on_date'];
            $this->model->deleteDataOnDate($delete_on_date);
            Session::setFlash('Дані по даті '.date_format(date_create($delete_on_date), "d.m.Y").' видалені!');
        }

        $this->data['dates'] = $this->model->getUniqueDataDate();
    }

    public function admin_warning() {
        if($_POST) {
            if(isset($_POST['delete'])) {
                $acc_number = isset($_POST['acc_number']) ? $_POST['acc_number'] : 0;
                $acc_number = (int)$acc_number;
                if($acc_number <= 0) {
                    Session::setFlash("Номер рахунку не може бути менше або рівний 0");
                } else {
                    $this->model->deleteWarning($acc_number);
                }
            } elseif(isset($_POST['change'])) {
                $acc_number = isset($_POST['acc_number']) ? $_POST['acc_number'] : 0;
                $acc_number = (int)$acc_number;
                $message = isset($_POST['message']) ? $_POST['message'] : '';
                $message = htmlspecialchars($message);
                if ($message == '') {
                    Session::setFlash("Попередження не може бути пустим!");
                } else {
                    $this->model->changeWarning($acc_number, $message);
                    Session::setFlash("Попередження змінено");
                }
            } elseif(isset($_POST['add'])) {
                $acc_number = isset($_POST['acc_number']) ? $_POST['acc_number'] : 0;
                $acc_number = (int)$acc_number;
                if($acc_number <= 0) {
                    Session::setFlash("Номер рахунку не може бути менше або рівний 0");
                } else {
                    $message = isset($_POST['message']) ? $_POST['message'] : '';
                    $message = htmlspecialchars($message);
                    if ($message == '') {
                        Session::setFlash("Попередження не може бути пустим!");
                    } else {
                        $this->model->addWarning($acc_number, $message);
                        Session::setFlash("Попередження відправлено");
                    }
                }
            }
        }
        $this->data['warnings'] = $this->model->getWarningList();
    }

    public function admin_export() {
        if (isset($_POST['export'])) {
            $this->data['indexes_to_import'] = $this->model->getUncheckedIndexes();
        } elseif (isset($_POST['checked'])) {
            $this->model->checkAllIndexes();
            Session::setFlash("Показники набули статус перевірених!");
        }

        $this->data['unchecked_indexes'] = $this->model->getUncheckedIndexesCount();
    }


    // API methods

    // get account info
    public function api_account() {
        $is_error = true;
        if ($_POST) {

            $acc_number = '';
            $soname = '';
            if (isset($_POST['accountNumber'])) {

                $acc_number = $_POST['accountNumber'];
                if (isset($_POST['soname'])) {
                    $soname = $_POST['soname'];
                    $person = $this->model->getByAccNumber($acc_number);
                    if(isset($person['acc_soname'])) {
                        if (mb_strtolower($person['acc_soname']) == mb_strtolower($soname)) {
                            //user is valid
                            $is_error = false;
                            $this->data['account'] = $this->model->getByAccNumber($acc_number);
                        }
                    }
                }
            }
        }
        if($is_error) {
            $this->data['api_error'] = Config::get('api_error_wrong_user_data');
        }
    }

    public function api_data() {
        $is_error = true;
//        $_POST['accountNumber'] = 100;
//        $_POST['soname'] = 'КиРиЧеНкО';
//        $_POST['from'] = 10950;
        if ($_POST) {
            $acc_number = '';
            $soname = '';
            if (isset($_POST['accountNumber'])) {
                $acc_number = $_POST['accountNumber'];
                if (isset($_POST['soname'])) {
                    $soname = $_POST['soname'];
                    $person = $this->model->getByAccNumber($acc_number);
                    if(isset($person['acc_soname'])) {
                        if (mb_strtolower($person['acc_soname']) == mb_strtolower($soname)) {
                            //user is valid
                            if (isset($_POST["from"])) {
                                $is_error = false;
                                $from = (int)$_POST["from"];
                                $this->data['acc_data'] = $this->model->getDataList($acc_number, $from);
                            }
                        }
                    }

                }
            }
        }
        if($is_error) {
            $this->data['api_error'] = Config::get('api_error_wrong_user_data');
        }

    }

    public function api_indexes() {
        $is_error = true;
//        $_POST['accountNumber'] = 100;
//        $_POST['soname'] = 'КиРиЧеНкО';
//        $_POST['from'] = 9;
        if ($_POST) {
            $acc_number = '';
            $soname = '';
            if (isset($_POST['accountNumber'])) {
                $acc_number = $_POST['accountNumber'];
                if (isset($_POST['soname'])) {
                    $soname = $_POST['soname'];
                    $person = $this->model->getByAccNumber($acc_number);
                    if(isset($person['acc_soname'])) {
                        if (mb_strtolower($person['acc_soname']) == mb_strtolower($soname)) {
                            //user is valid
                            if (isset($_POST["from"])) {
                                $is_error = false;
                                $from = (int)$_POST["from"];
                                $this->data['acc_indexes'] = $this->model->getIndexList($acc_number, $from, 'asc');
                            }
                        }
                    }
                }
            }
        }
        if($is_error) {
            $this->data['api_error'] = Config::get('api_error_wrong_user_data');
        }
    }

    public function api_warning() {
        $is_error = true;
//        $_POST['accountNumber'] = 100;
//        $_POST['soname'] = 'КиРиЧеНкО';
        if ($_POST) {
            $acc_number = '';
            $soname = '';
            if (isset($_POST['accountNumber'])) {
                $acc_number = $_POST['accountNumber'];
                if (isset($_POST['soname'])) {
                    $soname = $_POST['soname'];
                    $person = $this->model->getByAccNumber($acc_number);
                    if(isset($person['acc_soname'])) {
                        if (mb_strtolower($person['acc_soname']) == mb_strtolower($soname)) {
                            //user is valid
                            $is_error = false;
                            $this->data['warning'] = $this->model->getWarning($acc_number);
                            // delete warning after api show it (comment next line if don't need it)
                            $this->model->deleteWarning($acc_number);
                        }
                    }
                }
            }
        }
        if($is_error) {
            $this->data['api_error'] = Config::get('api_error_wrong_user_data');
        }

    }

    public function api_send() {
        $is_error = true;
//        $_POST['accountNumber'] = 100;
//        $_POST['soname'] = 'КиРиЧеНкО';
//        $_POST['index'] = 45;
        if ($_POST) {
            $acc_number = '';
            $soname = '';
            if (isset($_POST['accountNumber'])) {
                $acc_number = $_POST['accountNumber'];
                if (isset($_POST['soname'])) {
                    $soname = $_POST['soname'];
                    $person = $this->model->getByAccNumber($acc_number);
                    if(isset($person['acc_soname'])) {
                        if (mb_strtolower($person['acc_soname']) == mb_strtolower($soname)) {
                            //user is valid
                            if (isset($_POST["index"])) {
                                $is_error = false;
                                $index = (int)$_POST["index"];
                                if (date("d") >= Config::get('send_index_from_day')) {
                                    if ($index > 0) {
                                        $this->model->saveIndex($acc_number, $index, 'api');
                                        $this->data['api_error'] = Config::get('api_index_received');
                                    } else {
                                        $this->data['api_error'] = Config::get('api_error_wrong_user_data');
                                    }
                                } else {
                                    $this->data['api_error'] = Config::get('api_error_early');
                                }
                            }
                        }
                    }
                }
            }
        }
        if($is_error) {
            $this->data['api_error'] = Config::get('api_error_wrong_user_data');
        }
    }
}