<!DOCTYPE html>
<html>
<head>
    <title><?=Config::get('site_name')?></title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width; initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <link rel="stylesheet" type="text/css" href="/css/news.css">
    <link rel="stylesheet" type="text/css" href="/css/documents.css">

    <link rel="shortcut icon" type="image/png" href="/img/favicon.png"/>
</head>
<body>
<div id="wrapper">
    <header>
        <div class="inner">
            <div id="header-logo">
                <a href="/">
                    <img src="/img/logo.png" height="100px">
                </a>
                <a href="/" style="margin-top:15px; margin-left: 60px; position: absolute;">
                    Кам'янське УЕГГ<br>
                    філія ПАТ "Черкасигаз"
                </a>
            </div>
            <div id="header-login">
                Служба обліку природного газу
            </div>
            <div class="clear"></div>
        </div>
    </header>
    <div id="top-menu">
        <div id="top-menu-small">
            <div id="menu_link"></div>
            <div id="menu_body" style="display: none;">
                <ul>
                    <li><a href="/">Головна</a></li>
                    <li><a href="/news">Новини</a></li>
                    <li><a href="/pages/documents">Нормативні документи</a></li>
                    <li><a href="/personal">Особовий рахунок</a></li>
                    <li><a href="/pages/contacts">Контакти</a></li>
                </ul>
            </div>
        </div>
        <div id="top-menu-normal">
            <ul>
                <li><a href="/">Головна</a></li>
                <li><a href="/news">Новини</a></li>
                <li><a href="/pages/documents">Нормативні документи</a></li>
                <li><a href="/personal">Особовий рахунок</a></li>
                <li><a href="/pages/contacts">Контакти</a></li>
            </ul>
        </div>
    </div>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#menu_link').click(function(){
                $(this).parent().children('div#menu_body').toggle('normal');
                return false;
            });
        });
    </script>
    <div id="main">
        <div id="content">
            <div class="inner">
                <?php
                if(Session::hasFlash()) {
                    ?>
                    <div class="flash"><?=Session::flash()?></div>
                <?php } ?>
                    <?=$data['content']?>

            </div>
        </div>


        <div id="navigation">
            <div class="inner">
                <div class="info-item">
                    <img src="/img/important.png" alt="important" align="left" style="margin-top: 15px;">
                    Якщо ви почули запах газу у вашій оселі – негайно телефонуйте <h2 style="font-size: 27px; color: #fd5c48;">104</h2>
                </div>
                <div class="info-item">
                    <img src="/img/Gnome-Stock-Person-64.png" alt="persons" align="left">
                    <h2><?=$data['account_count']?></h2>
                    абонентів
                </div>
                <div class="info-item">
                    <a href="/personal">
                        <img src="/img/send.png" alt="send" align="left">
                        Передати<br> показник<br> лічильника
                    </a>
                </div>

            </div>
        </div>

        <div class="clear"></div>
    </div>
    <footer>
        <div class="inner">
            <div id="footer-menu">
                <ol>
                    <li><a href="/news">Новини</a></li>
                    <li><a href="/pages/documents">Нормативні документи</a></li>
                    <li><a href="/personal">Передати показник лічильника</a></li>
                    <li><a href="/pages/contacts">Контакти</a></li>
                </ol>
            </div>
            <div id="footer-info">
                <div class="phone">38(047)32 6-17-97</div>
                <div class="mail">kam_opg@ukr.net</div>
            </div>
            <div class="clear"></div>
            <div id="copyright">
                © 2015 Кам'янське управління експлуатації газового господарства - філія ПАТ "Черкасигаз"<br>
                Усі матеріали сайту є авторськими та захищені законом України "Про авторські та суміжні права"
            </div>
            <div id="copyright-small">
                © 2015 КУЕГГ - філія ПАТ "Черкасигаз"<br>
                Матеріали сайту захищені законом України "Про авторські та суміжні права"
            </div>
            <div id="developer"><a href="http://qconer.com/" target="_blank"><img src="/img/qconer.png" height="45px" alt="developed by QCONER STUDIO" title="developed by QCONER STUDIO"></a></div>
        </div>
    </footer>
</div>
</body>
</html>