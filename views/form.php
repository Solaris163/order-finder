<h2>Поиск заказов</h2>

<!--Форма поиска по имени, фамилии и отчеству заказчика-->
<form class='order-form' action="/order/index/" method="post">
    Введите имя или фамилию заказчика (или часть имени или фамилии)
    <input class="text" type="text" name="name">
    <input class="text link" type="submit" name="send" value="Найти">
</form>
<div class="small-text">Например "Иванов" или просто "Ива". Поиск идет по имени, фамилии и отчеству</div>

<!--Форма поиска по адресу заказчика-->
<form class='order-form' action="/order/index/" method="post">
    Введите адрес заказчика (или часть адреса)
    <input class="text" type="text" name="address">
    <input class="text link" type="submit" name="send" value="Найти">
</form>
<div class="small-text">Например "Мичурина" или "Некрасова" или "Самара"</div>

<!--Форма поиска по номеру телефона заказчика-->
<form class='order-form' action="/order/index/" method="post">
    Введите телефон заказчика (или часть телефона)
    <input class="text" type="text" name="phone">
    <input class="text link" type="submit" name="send" value="Найти">
</form>
<div class="small-text">Например 555555 или 937</div>

<!--Форма поиска по стоимости заказа-->
<form class='order-form' action="/order/index/" method="post">
    Введите стоимость заказа
    <input class="text" type="text" name="cost">
    <input class="text link" type="submit" name="send" value="Найти">
</form>
<div class="small-text">Например 10000</div>

<!--Форма поиска по комментарию к заказу-->
<form class='order-form' action="/order/index/" method="post">
    Введите текст комментария (или часть текста)
    <input class="text" type="text" name="comment">
    <input class="text link" type="submit" name="send" value="Найти">
</form>
<div class="small-text">Например "первый"</div>

<!--Форма поиска по имени менеджера, ответственного за заказ-->
<form class='order-form' action="/order/index/" method="post">
    Выберите имя менеджера, ответственного за заказ
    <select class="text select" name="manager_id">
        <!--Выведем список возможных менеджеров, полученных из базы данных-->
        <?php foreach ($managers as $manager): ?>
            <option value="<?=$manager['id']?>"><?=$manager['name']?></option>
        <?php endforeach; ?>
    </select>
    <input class="text link" type="submit" name="send" value="Найти">
</form>

<!--Форма поиска по дате патежа-->
<form class='order-form' action="/order/index/" method="post">
    Выберите дату платежа
    <input class="text" type="date" name='payment_date'>
    <input class="text link" type="submit" name="send" value="Найти">
</form>
<div class="small-text">Например выберите 1 августа 2020 г.</div>

<!--Форма поиска задолжников-->
<form class='order-form' action="/order/index/" method="post">
    Для поиска должников просто нажмите кнопку: 
    <input class="text" type="hidden" name='debtor' value="debtor">
    <input class="text link" type="submit" name="send" value="Найти">
</form>
