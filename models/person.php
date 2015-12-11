<?php

class Person extends Model {

    public function getByAccNumber($acc_number) {
        $acc_number = (int) $acc_number;
        $sql = "select * from account where acc_number = {$acc_number} limit 1";
        return $this->db->query($sql)[0];
    }

    public function getAccountCount() {
        $sql = "select count(*) from account";
        return $this->db->query($sql)[0]['count(*)'];
    }

    public function getDataList($acc_number, $from = 0) {
        $acc_number = (int) $acc_number;
        $from = (int)$from;
        $sql = "select * from account_data where acc_number = {$acc_number} and id > {$from} order by on_date desc";
        return $this->db->query($sql);
    }

    public function getIndexList($acc_number, $from = 0, $date_order_by_param = 'desc') {
        $acc_number = (int) $acc_number;
        $from = (int)$from;
        $date_order_by_param = strtolower($date_order_by_param);
        $date_order_by_param = ($date_order_by_param == 'desc' || $date_order_by_param == 'asc') ? $date_order_by_param : 'desc';
        $status_order_by_param = $date_order_by_param == 'desc' ? 'asc' : 'desc';
        $sql = "select * from account_index where acc_number = {$acc_number} and id >= {$from} order by on_date {$date_order_by_param}, status {$status_order_by_param}";
        return $this->db->query($sql);
    }

    public function saveIndex($acc_number, $last_index, $from_source) {
        $acc_number = (int)$acc_number;
        $last_index = (int)$last_index;
        $from_source = $this->db->escape($from_source);
        $current_date = date_format(date_create(), "Y-m-d");
        $sql = "select count(*) from account_index
                  where
                    acc_number = {$acc_number} and
                    status = 0;";

        if ($this->db->query($sql)['0']['count(*)'] != 0) {

            $sql = "update account_index
                        set
                            last_index = {$last_index},
                            from_source = '{$from_source}'
                        where
                            acc_number = {$acc_number} and
                            status = 0;
        ";

        }
        else {
            $sql = "insert into account_index
                        set
                            acc_number = {$acc_number},
                            last_index = {$last_index},
                            on_date = '{$current_date}',
                            status = 0,
                            from_source = '{$from_source}';
        ";
        }
        return $this->db->query($sql);
    }

    public function saveData($acc_number, $soname, $name, $middle_name, $street, $house, $flat, $acc_index, $balance, $on_date) {
        $soname = $this->db->escape($soname);
        $name = $this->db->escape($name);
        $middle_name = $this->db->escape($middle_name);
        $street = $this->db->escape($street);
        $house = $this->db->escape($house);
        $flat = $this->db->escape($flat);
        $on_date = date_format(date_create($on_date), "Y-m-d");

        $sql_insert_data = "insert into account_data
                              set
                                acc_number = {$acc_number},
                                last_index = {$acc_index},
                                balance = {$balance},
                                on_date = '{$on_date}'
                           ";




        $sql = "select count(*) from account
                  where
                    acc_number = {$acc_number};";
        if ($this->db->query($sql)['0']['count(*)'] != 0) {
            $sql = "update account
                        set
                            acc_soname = '{$soname}',
                            acc_name = '{$name}',
                            acc_middle_name = '{$middle_name}',
                            acc_street = '{$street}',
                            acc_house = '{$house}',
                            acc_flat = '{$flat}'
                        where
                            acc_number = {$acc_number}
                   ";
        } else {
            $sql = "insert into account
                        set
                            acc_number = {$acc_number},
                            acc_soname = '{$soname}',
                            acc_name = '{$name}',
                            acc_middle_name = '{$middle_name}',
                            acc_street = '{$street}',
                            acc_house = '{$house}',
                            acc_flat = '{$flat}'
                   ";
        }
        return ($this->db->query($sql_insert_data) && $this->db->query($sql));
    }

    public function getUniqueDataDate() {
        $sql = "select on_date from account_data group by on_date order by on_date desc";
        return $this->db->query($sql);
    }

    public function deleteDataOnDate($delete_on_date) {
        $delete_on_date = $this->db->escape($delete_on_date);
        $sql = "delete from account_data where on_date = '{$delete_on_date}'";
        return $this->db->query($sql);
    }

    public function getWarningList() {
        $sql = "select * from account_warnings order by acc_number";
        return $this->db->query($sql);
    }

    public function getWarning($acc_number) {
        $acc_number = $this->db->escape($acc_number);
        $sql = "select message from account_warnings where acc_number = $acc_number";
        return $this->db->query($sql)[0]['message'];
    }


    public function deleteWarning($acc_number) {
        $acc_number = (int)$acc_number;
        $sql = "delete from account_warnings where acc_number = $acc_number";
        return $this->db->query($sql);
    }

    public function changeWarning($acc_number, $message) {
        $acc_number = $this->db->escape($acc_number);
        $message = $this->db->escape($message);
        $sql = "update account_warnings set message = '{$message}' where acc_number = {$acc_number}";
        return $this->db->query($sql);
    }

    public function addWarning($acc_number, $message) {
        $acc_number = $this->db->escape($acc_number);
        $message = $this->db->escape($message);

        $sql = "select count(*) from account_warnings
                  where
                    acc_number = {$acc_number};";
        if ($this->db->query($sql)['0']['count(*)'] != 0) {
            $sql = "update account_warnings
                        set
                            message = '{$message}'
                        where
                            acc_number = {$acc_number}
                   ";
        } else {
            $sql = "insert into account_warnings
                        set
                            acc_number = {$acc_number},
                            message = '{$message}'
                   ";
        }
        return $this->db->query($sql);
    }

    public function getUncheckedIndexesCount() {
        $sql = "select count(*) from account_index where status = 0";
        return $this->db->query($sql)[0]['count(*)'];
    }

    public function getUncheckedIndexes() {
        $sql = "select  ai.acc_number    as acc_number,
                        ai.last_index    as last_index,
                        ai.on_date       as on_date,
                        ai.from_source   as from_source,
                        ac.acc_name      as acc_name,
                        ac.acc_soname    as acc_soname
                    from account_index ai
                    inner join account ac on ai.acc_number = ac.acc_number
                    where ai.status = 0
                    order by ai.on_date";
        return $this->db->query($sql);
    }

    public function checkAllIndexes() {
        $sql = "update account_index
                    set
                      status = 1
                    where
                      status = 0";
        return $this->db->query($sql);
    }
}