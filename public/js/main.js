
//смена цвета у строки заказа при наведении мыши
$('.order-tr').hover(function() {
    $( this ).addClass('active');
}, function() {
    $( this ).removeClass('active');
});


//отправление POST-запроса при клике на строку заказа
$(document).on('click', '.order-tr', function(e) {
    $(".popup").css({'display': 'block'}); //показ всплывающего окна с сообщением об ожидании
    send($(this).attr('id')); //вызов функции send() и передача в нее id того заказа, по которому был клик
});

//функция отправляет на сервер POST запрос с id заказа и вызывает функцию render(), передавая ей ответ сервера
function send(order_id) {
    $.ajax({
        type: 'POST',
        url: '/order/detail/',
        data: {id: order_id},
        success: function(answer) {
            answer = $.parseJSON(answer); 
            $(".search-result").css({'display': 'none'}); //скрытие ранее показанных заказов
            $(".popup").css({'display': 'none'}); //скрытие всплывающего окна с сообщением об ожидании
            render(answer);
        },
        error:  function(){
            alert('Попробуйте еще раз');
        }
    });
}


//функция получает подробные данные о заказе и выводит их на страницу
function render(order) {
    $('#order-id').text(order.payments[0].id); //вставка id заказа
    $('#customer').text(order.payments[0].surname + ' ' + order.payments[0].name + ' ' + order.payments[0].patronymic); //вставка ФИО заказчика
    $('#address').text(order.payments[0].address); //вставка адрес заказчика
    $('#phone').text(order.payments[0].phone); //вставка телефон заказчика
    order.managers.forEach(function(manager) {
        $('#managers').append('<div>' + manager.name + '</div>') //вставка имена менеджеров, отвественных за заказ
    });
    $('#cost').text(order.payments[0].cost + ' р.'); //вставка полной стоимости заказа
    order.works.forEach(function(work) {
        $('#works').append('<div>' + work.title + ' ' + work.cost + ' р. </div>') //вставка выполненных работ по заказу
    });
    order.payments.forEach(function(payment) {
        if (payment.sum != null) {
            $('#payments').append('<div>' + payment.date + ' ' + payment.sum + ' р. ' + payment.kind_name + '</div>') //вставка платежей
        }
    });
    $('#comment').text(order.payments[0].comment); //вставка комментария к заказу
    $('.order-detail').css({'display': 'block'}); //показать готовый заказ
}
