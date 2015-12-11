<?php
if(isset($data['indexes_to_import'])) {
    $csv_data = array();
    $titles = array(
        iconv("UTF-8", "WINDOWS-1251","Дата"),
        iconv("UTF-8", "WINDOWS-1251","Рахунок"),
        iconv("UTF-8", "WINDOWS-1251","Ім'я"),
        iconv("UTF-8", "WINDOWS-1251","Прізвище"),
        iconv("UTF-8", "WINDOWS-1251","Показник"),
        iconv("UTF-8", "WINDOWS-1251","Ресурс"));
    foreach($data['indexes_to_import'] as $indexes) {
        $row_csv = array(
            iconv("UTF-8", "WINDOWS-1251",$indexes['on_date']),
            iconv("UTF-8", "WINDOWS-1251",$indexes['acc_number']),
            iconv("UTF-8", "WINDOWS-1251",$indexes['acc_name']),
            iconv("UTF-8", "WINDOWS-1251",$indexes['acc_soname']),
            iconv("UTF-8", "WINDOWS-1251",$indexes['last_index']),
            iconv("UTF-8", "WINDOWS-1251",$indexes['from_source']));
        $csv_data[] = $row_csv;
    }
    function download_send_headers($filename) {
// disable caching
        $now = gmdate("D, d M Y H:i:s");
        header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Last-Modified: {$now} GMT");

// force download
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");

// disposition / encoding on response body
        header("Content-Disposition: attachment;filename={$filename}");
        header("Content-Transfer-Encoding: binary");
    }

    function array2csv(array &$array, $titles) {
        if (count($array) == 0) {
            return null;
        }
        ob_start();
        $df = fopen("php://output", 'w');
        fputcsv($df, $titles, ';');
        foreach ($array as $row) {
            fputcsv($df, $row, ';');
        }
        fclose($df);
        return ob_get_clean();
    }

    download_send_headers("data_export.csv");
    echo array2csv($csv_data, $titles);
    die();
}
?>

<h3>Експорт</h3>
<?php
if ($data['unchecked_indexes'] == 0) {
    echo "У вас немає неперевірених даних";
}else {
?>
<strong>Неперевірених показників: <?=$data['unchecked_indexes']?></strong><br>
    <form class="form-inline" role="form" method="post" action="">
        <input type="submit" name="export" class="btn btn-success" value="Експорт"><br>
        Щоб показники набули статусу перевірені, натисніть:<br>
        <input type="submit" name="checked" class="btn btn-warning" value="Показники перевірені">
    </form>
<?php
}
?>



