<?php
    if ( is_null(Session::get('person')) ) {
?>
<h1>Особовий рахунок</h1>
<form action="" method="post">
    Номер особового рахунку<sup>*</sup>:<br>
    <input name="acc_number" onkeyup="return accNumberKeyUp(event.keyCode)" onkeydown="return accNumberKey(event.keyCode)" type="text" size="6" class="acc_number" id="acc_number" maxlength="6">
    <br>Прізвище:<br><input type="text" name="acc_soname" id="acc_surname"><br>
    <input type="submit" value="Вхід">
</form>

<?php
    } else {
?>
<link rel="stylesheet" type="text/css" href="/css/personal.css">
<h1>Особовий рахунок <?=$data['account']['acc_number']?></h1>
<div id="personal">
    <a href="/personal/logout" class="logout-button">Вихід</a>
    <div id="personal-info">
        <div class="row">
            <div class="personal-key">
                Номер рахунку:
            </div>
            <div class="personal-value">
                <?=$data['account']['acc_number']?>
            </div>
        </div>
        <div class="row">
            <div class="personal-key">
                Прізвище:
            </div>
            <div class="personal-value">
                <?=mb_ucfirst($data['account']['acc_soname'])?>
            </div>
        </div>
        <div class="row">
            <div class="personal-key">
                Ім'я:
            </div>
            <div class="personal-value">
                <?=mb_ucfirst($data['account']['acc_name'])?>
            </div>
        </div>
        <div class="row">
            <div class="personal-key">
                По-батькові:
            </div>
            <div class="personal-value">
                <?=mb_ucfirst($data['account']['acc_middle_name'])?>
            </div>
        </div>
        <div class="row">
            <div class="personal-key">
                Вулиця:
            </div>
            <div class="personal-value">
                <?=$data['account']['acc_street']?>
            </div>
        </div>
        <div class="row">
            <div class="personal-key">
                Будинок:
            </div>
            <div class="personal-value">
                <?=$data['account']['acc_house']?>
            </div>
        </div>
        <div class="row">
            <div class="personal-key">
                Квартира:
            </div>
            <div class="personal-value">
                <?=$data['account']['acc_flat']?>
            </div>
        </div>
    </div>

    <?php
        if(isset($data['warning'])) {
    ?>
            <div id="warning">
                <a href="/personal/warned" id="delete-warning" title="Видалити повідомлення">x</a>
                <?=$data['warning']?>
            </div>
    <?php
        }
    ?>

    <h2>Передати показник лічильника на кінець місяця</h2>
    <div id="send-index">
        <form action="/personal/send" method="post">
            Введіть показник на кінець місяця<sup><b>*</b></sup>:<br><input type="text" name="last_index" maxlength="5"><br>
            <input type="submit" value="Передати">
        </form>
        <br>
        <sup><b>*</b></sup> Переданий показник може бути змінено, поки він має статус "Не перевірено"
    </div>

    <?php
    if (!empty($data['account_data'])) {
        $is_more_info = false;
        $history_counter = 0;
    ?>
        <h2>Стан рахунку</h2>
        <div class="history-table">
            <div class="row table-header">
                <div class="item">
                    Дата
                </div>
                <div class="item">
                    Показник(м<sup>3</sup>)
                </div>
                <div class="item">
                    Залишок(грн.)
                </div>
            </div>

            <?php
            foreach($data['account_data'] as $history_data) {
                $history_counter++;
                if ($history_counter > 5 && !$is_more_info) {
            ?>
                    <div class="spoiler_body">
                <?php
                $is_more_info = true;
                }
                ?>
                        <div class="row">
                            <div class="item">
                                <?=date_format(date_create($history_data['on_date']), "d.m.Y")?>
                            </div>
                            <div class="item">
                                <?=$history_data['last_index']?>
                            </div>
                            <div class="item">
                                <?php
                                    if ($history_data['balance'] <=0) {
                                ?>
                                        <div style="color: #00FF00; font-weight: 900;"><?=$history_data['balance']?></div>
                                <?php
                                    } else {
                                ?>
                                        <div style="color: #FF0000; font-weight: 900;"><?=$history_data['balance']?></div>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>
            <?php
            }
            if ($is_more_info) {
            ?>
                        <div class="history-more-empty"></div>
                    </div>
            <div class="history-more"></div>

            <?php
            }
            ?>
            </div>
    <?php
    }
    ?>

    <?php
    if (!empty($data['account_index'])) {
        $is_more_info = false;
        $history_counter = 0;
        ?>
        <h2>Передані показники</h2>
        <div class="history-table">
            <div class="row table-header">
                <div class="item">
                    Дата
                </div>
                <div class="item">
                    Показник(м<sup>3</sup>)
                </div>
                <div class="item">
                    Статус
                </div>
            </div>

            <?php
            foreach($data['account_index'] as $history_data) {
            $history_counter++;
            if ($history_counter > 5 && !$is_more_info) {
            ?>
            <div class="spoiler_body">
                <?php
                $is_more_info = true;
                }
                ?>
                <div class="row">
                    <div class="item">
                        <?=date_format(date_create($history_data['on_date']), "d.m.Y")?>
                    </div>
                    <div class="item">
                        <?=$history_data['last_index']?>
                    </div>
                    <div class="item">
                        <?php
                        if ($history_data['status'] == 1) {
                            ?>
                            <img src="/img/tick.png" alt="Прийнято" title="Прийнято" height="10px"> Прийнято
                        <?php
                        } else {
                            ?>
                            <img src="/img/wait.png" alt="Не перевірено" title="Не перевірено" height="10px"> Не перевірено
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <?php
                }
                if ($is_more_info) {
                ?>
                <div class="history-more-empty"></div>
            </div>
            <div class="history-more"></div>

        <?php
        }
        ?>
        </div>
    <?php
    }
    ?>

    <a href="/personal/logout" class="logout-button">Вихід</a>
   </div>
<?php
    }
?>

<script src="/js/personal_key_listener.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.history-more').click(function(){
            $(this).parent().children('div.spoiler_body').toggle('normal');
            return false;
        });
    });
</script>