<?php
if (isset($data['api_error'])) {
    echo $data['api_error'];
}
else {
    $api_result = "{\"accountNumber\":{$data['account']['acc_number']},\"name\":\"{$data['account']['acc_name']}\",\"soname\":\"{$data['account']['acc_soname']}\",\"middleName\":\"{$data['account']['acc_middle_name']}\",\"street\":\"{$data['account']['acc_street']}\",\"house\":\"{$data['account']['acc_house']}\",\"flat\":\"{$data['account']['acc_flat']}\"}";
    echo $api_result;
}