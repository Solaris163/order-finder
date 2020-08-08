<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/style/main.css">
    <title>Заказы</title>
</head>
<body>
<div class="main-container">
    <header>
        <h1 class="header-h1">Программа поиска заказов</h1>
        <div class="header-menu">
            <div class="flex header-left">
                <form action="/" method="post">
                    <button>Поиск заказа</button>
                </form>
                <form action="/order/index/" method="post">
                    <button>Показать все заказы</button>
                </form>
            </div>
        </div>
    </header>

    <?=$content?>
</div>

<div class="popup">
    <div class="popup-content">
        Подождите...
    </div>
</div>

<script src="/js/jquery-3.4.1.js"></script>
<script src="/js/main.js"></script>
</body>
</html>
