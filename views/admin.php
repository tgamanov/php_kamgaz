<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <link rel="shortcut icon" type="image/png" href="/img/favicon.png"/>
    <title>Admin page</title>
    <style>
        .btn {
            margin-top: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <?php
    if(Session::hasFlash()) {
        ?>
        <br><br>
        <div class="alert alert-warning"><?php Session::flash()?></div>
    <?php } ?>
<?php
if (!is_null(Session::get('user'))) {
    ?>
    <a href="/admin" class="btn btn-info">Імпорт</a>
    <a href="/admin/personal/export" class="btn btn-info">Експорт</a>
    <a href="/admin/news" class="btn btn-info">Новини</a>
    <a href="/admin/personal/warning" class="btn btn-info">Попередження</a>
    <a href="/admin/personal/delete" class="btn btn-info">Видалити дані</a>
    <a href="/admin/users/change" class="btn btn-info">Змінити пароль</a>
    <hr>
    <a href="/admin/users/logout" class="btn btn-danger">Вихід</a>
    <hr>
<?php
}
?>

<?=$data['content']?>



</div>
</body>
</html>