<?php
if (!empty($data['top_news'])) {
?>
<h1>Важливі новини</h1>
<?php
foreach($data['top_news'] as $top_news) {
    ?>
    <div class="news top">
        <a href="/news/view/<?=$top_news['id']?>" class="title"><?=$top_news['n_title']?></a>
        <div class="date">
            <?=date_format(date_create($top_news['n_date']), "d.m.Y")?>
        </div>
        <div class="body">
            <?=$top_news['n_description']?>
        </div>
        <a href="/news/view/<?=$top_news['id']?>" class="more">Детальніше...</a>
    </div>
<?php
}
?>
<?php
} else {
?>
    <h1>Останні новини</h1>
    <?php
    foreach($data['regular_news'] as $news) {
        ?>
        <div class="news">
            <a href="/news/view/<?=$news['id']?>" class="title"><?=$news['n_title']?></a>
            <div class="date">
                <?=date_format(date_create($news['n_date']), "d.m.Y")?>
            </div>
            <div class="body">
                <?=$news['n_description']?>
            </div>
            <a href="/news/view/<?=$news['id']?>" class="more">Детальніше...</a>
        </div>
    <?php
    }
}
?>

<div id="documents">
    <h2>Закони України</h2>
    <ul>
        <li><a href="http://chergas.ck.ua/docs/zakon_komerz_oblik.pdf" target="_blank">Про забезпечення комерційного обліку</a></li>
        <li><a href="http://chergas.ck.ua/docs/zasadu_runky_gaza.pdf" target="_blank">Про засади функціонування ринку природного газу</a></li>
        <li><a href="http://chergas.ck.ua/docs/zakon_zkp.pdf" target="_blank">Про житлово-комунальні послуги</a></li>
        <li><a href="http://chergas.ck.ua/docs/zakon_nafta_i_gaz.pdf" target="_blank">Про нафту і газ</a></li>
        <li><a href="http://chergas.ck.ua/docs/zakon_zvernennya.pdf" target="_blank">Про звернення громадян </a></li>
    </ul>
</div>