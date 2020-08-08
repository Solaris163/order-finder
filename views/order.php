<!--Вывод результатов поиска заказов-->
<div class="search-result">
    <h2>Результаты поиска</h2>
    <h3>Для подробного просмотра нажмите на заказ</h3>

    <table class="order-table">
        <thead>
            <tr>
                <th>id</th>
                <th>Фамилия</th>
                <th>Имя</th>
                <th>Отчество</th>
                <th>Стоимость</th>
                <th>Оплачено</th>
                <th>Комментарий</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($content as $order): ?>
            <tr id="<?=$order['id'];?>" class="order-tr">
                <td><?=$order['id'];?></td>
                <td><?=$order['surname'];?></td>
                <td><?=$order['name'];?></td>
                <td><?=$order['patronymic'];?></td>
                <td><?=$order['cost'];?></td>
                <td><?= isset($order['sum']) ? $order['sum'] : 0 ;?></td>
                <td><?=$order['comment'];?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>    
    </table>
</div>
<!--Конец вывода результатов поиска заказов-->

<!--Вывод детальной информации по заказу-->
<div class="order-detail">
    <div class="order-detail-h2">Просмотр заказа № <span id="order-id"></span></div>
    <div class="flex order-detail-item">
        <div class="">Заказчик:&nbsp</div>
        <div class="" id="customer"></div>
    </div>
    <div class="flex order-detail-item">
        <div class="">Адрес:&nbsp</div>
        <div class="" id="address"></div>
    </div>
    <div class="flex order-detail-item">
        <div class="">Телефон:&nbsp</div>
        <div class="" id="phone"></div>
    </div>
    <div class="flex order-detail-item">
        <div class="">Менеджеры, ответственные за проект:&nbsp</div>
        <div class="" id="managers"></div>
    </div>
    <div class="flex order-detail-item">
        <div class="">Общая стоимость заказа по договору:&nbsp</div>
        <div class="" id="cost"></div>
    </div>
    <div class="flex order-detail-item">
        <div class="">Выполненные работы:&nbsp</div>
        <div class="" id="works"></div>
    </div>
    <div class="flex order-detail-item">
        <div class="">Платежи по заказу:&nbsp</div>
        <div class="" id="payments"></div>
    </div>
    <div class="flex order-detail-item">
        <div class="">Комментарий:&nbsp</div>
        <div class="" id="comment"></div>
    </div>
</div>
<!--Конец вывода детальной информации по заказу-->