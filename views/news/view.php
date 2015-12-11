<?php
if (isset($data['news'])) {
?>
<h1><?=$data['news']['n_title']?></h1>
<div class="news">
    <div class="date">
        <?=date_format(date_create($data['news']['n_date']), "d.m.Y")?>
    </div>
    <div class="body">
        <?=$data['news']['n_body']?>
    </div>
</div>
<?php } else { ?>
    <h1>Новини не існує, або вона була видалена</h1>
<?php } ?>