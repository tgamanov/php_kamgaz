<h3>Попередження</h3>
<div id="warnings" style="overflow-y: scroll; max-height:400px;">
    <?php
    foreach($data['warnings'] as $warning) {
    ?>
    <form class="form-inline" role="form" method="post" action="">
        <input type="submit" name="change" class="btn btn-primary" value="Змінити">
        <input type="submit" name="delete" class="btn btn-danger" onClick="return confirm('Видалити дане попередження?\nНатисніть ок, щоб підтвердити')" value="Видалити">
        <div class="form-group">
            попередження <input type="text" class="form-control" id="message" name="message" value="<?=$warning['message']?>"> для рахунку <?=$warning['acc_number']?>
        </div>
        <input type="hidden" value="<?=$warning['acc_number']?>" name="acc_number">

    </form>
    <?php
    }
    ?>
</div>
<hr>
<form class="form-inline" role="form" method="post" action="">
    <input type="submit" name="add" class="btn btn-success" value="Додати">
    <div class="form-group">
        попередження <input type="text" class="form-control" id="message" name="message" value="">
    </div>
    <div class="form-group">
        для рахунку №<input type="text" class="form-control" id="acc_number" name="acc_number" value="">
    </div>

</form>