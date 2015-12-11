<?php
if (isset($data['api_error'])) {
    echo $data['api_error'];
}
else {
    echo isset($data['warning']) ? $data['warning'] : Config::get('api_no_data');
}