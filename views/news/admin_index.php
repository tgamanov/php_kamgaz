<h3>Новини</h3>
<div id="warnings" style="overflow-y: scroll; max-height:400px;">
    <?php
    foreach($data['news'] as $single_news) {
        ?>
        <form class="form-inline" role="form" method="post" action="">
            <input type="submit" name="change" class="btn btn-primary" value="Змінити">
            <input type="submit" name="delete" class="btn btn-danger" onClick="return confirm('Видалити дану новину?\nНатисніть ок, щоб підтвердити')" value="Видалити">
            <div class="form-group">
                <label for="title">Заголовок:</label>
                <input type="text" class="form-control" id="title" name="title" value="<?=$single_news['n_title']?>">
            </div>
            <div class="form-group">
                <label for="description">Скорочено:</label>
                <input type="text" class="form-control" id="description" name="description" value="<?=$single_news['n_description']?>">
            </div>
            <div class="form-group">
                <label for="body">Повністю:</label>
                <input type="text" class="form-control" id="body" name="body" value="<?=$single_news['n_body']?>">
            </div>
            <div class="form-group">
                <label for="is_top">Важлива:</label>
                <input type="checkbox" name="is_top" id="is_top" <?php  if($single_news['n_type'] == 1) echo("checked"); ?>>
            </div>
            <input type="hidden" value="<?=$single_news['id']?>" name="id">
        </form>
    <?php
    }
    ?>

</div>

<hr>

<form class="form-inline" role="form" method="post" action="">
    <input type="submit" name="add" class="btn btn-success" value="Додати">
    <div class="form-group">
        <label for="title">Заголовок:</label>
        <input type="text" class="form-control" id="title" name="title" value="">
    </div>
    <div class="form-group">
        <label for="description">Скорочено:</label>
        <input type="text" class="form-control" id="description" name="description" value="">
    </div>
    <div class="form-group">
        <label for="body">Повністю:</label>
        <input type="text" class="form-control" id="body" name="body" value="">
    </div>
    <div class="form-group">
        <label for="is_top">Важлива:</label>
        <input type="checkbox" name="is_top" id="is_top">
    </div>
    <div class="form-group">
        <label for="on_date">Дата:</label>
        <input type="date" id="on_date" name="on_date" value="<?=date("Y-m-d")?>">
    </div>
</form>