<h3>Видалити дані по даті:</h3>
<form role="form" class="form-inline" action="" method="post">
    <div class="form-group">
        <select class="form-control" name="delete_on_date">
            <option value="" disabled>видалити дані</option>
            <?php
            foreach($data['dates'] as $date) {
            ?>
                <option value="<?=$date['on_date']?>"><?=date_format(date_create($date['on_date']), "d.m.Y")?></option>
            <?php
            }
            ?>
        </select>
    </div>
    <input class="btn btn-danger" type="submit" value="Видалити">
</form>