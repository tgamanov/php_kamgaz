<?php
if (isset($data['api_error'])) {
    echo $data['api_error'];
}
else {
    if (empty($data['acc_data'])) {
        echo Config::get('api_no_data');
    } else {
        $result = '[';
        foreach($data['acc_data'] as $item) {
            $format_date = date_format(date_create($item['on_date']), "d.m.Y");
            $result .= "{\"id\":{$item['id']},\"date\":\"{$format_date}\",\"balance\":{$item['balance']},\"index\":{$item['last_index']}}";

            if ($item !== end($data['acc_data'])) {
                $result.= ',';
            }
            else {
                $result.= ']';
            }
        }
        echo $result;
    }
}