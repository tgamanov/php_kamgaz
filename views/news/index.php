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
}
?>

<h1>Новини</h1>
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
if ($data['regular_news_count'] > 5) {
    $news_count = $data['regular_news_count'];
    $page_count = $news_count % 5 == 0 ? (int)($news_count / 5) : (int)($news_count / 5) + 1;
    $current_page = $data['current_page'];
?>
    <div class="pages">
<?php
if($current_page != 1) {
?>
    <a href="/news?page=<?=$current_page - 1?>"><< Попередня</a>
<?php
}
for ($i = 1; $i<= $page_count; $i++) {
    if ($current_page == $i) echo($i);
    else {
?>
        <a href="/news?page=<?=$i?>"><?=$i?></a>
<?php
    }
}
if ($current_page != $page_count) {
?>
    <a href="/news?page=<?=$current_page + 1?>">Наступна >></a>
<?php
}
?>
    </div>

<?php } ?>