<?php


namespace app\controllers;


use app\engine\Render;
use app\models\Manager;
use app\models\Work;
use app\models\Order;
use app\engine\VarDump;

/**
 * Класс отвечает за вывод информации о заказе
 * Class OrderController
 * @package app\controllers
 */
class OrderController extends Controller
{
    /**
     * @var Render
     */
    public $render; //рендер для рендеринга страниц

    /**
     * OrderController constructor.
     */
    public function __construct() {
        $this->render = new Render(); //создадим экземпляр класса Render для рендеринга страниц
    }

    /**
     * Метод получает данные о заказах и передает их в рендер для отображения на странице
     * Метод проверяет, есть ли post-запрос, и если есть то вызывает соответствующий метод модели класса Order для поиска заказов
     */
    public function actionIndex() {
    
        if (isset($_POST['send'])) {
            if (isset($_POST['name'])){
                $content = Order::getByCustomerName($_POST['name']); //поиск по имени, фамилии или отчеству заказчика
            } elseif (isset($_POST['address'])) {
                $content = Order::getByCustomerField('address', $_POST['address']); //поиск по адресу заказчика
            } elseif (isset($_POST['phone'])) {
                $content = Order::getByCustomerField('phone', $_POST['phone']); //поиск по номеру телефона заказчика
            } elseif (isset($_POST['cost'])) {
                $content = Order::getByCost($_POST['cost']); //поиск по стоимости заказа
            } elseif (isset($_POST['comment'])) {
                $content = Order::getByComment($_POST['comment']); //поиск по комментарию к заказу
            } elseif (isset($_POST['manager_id'])) {
                $content = Order::getByManagerId($_POST['manager_id']); //поиск по менеджерам, отвечающим за заказ
            } elseif (isset($_POST['payment_date'])) {
                //поиск заказов по дате платежей
                $date = date("Y-m-d", strtotime($_POST['payment_date'])); //приведем дату к тому формату, который используется в базе данных
                $content = Order::getByPaymentDate($date);
            } elseif (isset($_POST['debtor'])) {
                $content = Order::getDebtor(); //поиск заказов, по которым есть задолженности
            }
        } else {
            $content = Order::getAllOrders(); //если параметры не заданы, получим из базы все заказы
        }

        //Передадим в рендер массив с полученными заказами
        echo $this->render->renderPage('order.php', ['content' => $content]);
    }

    /**
     * Метод получает POST запрос и отправляет данные о заказе браузеру в виде json строки.
     */
    public function actionDetail() {

        if (isset($_POST['id'])){
            $id = $_POST['id'];

            //Выше, при поиске и промотре списка заказов, использовались не все восемь таблиц базы данных одновременно.
            //Максимум в одном запросе использовалось пять таблиц одновременно (например в методе getByManagerID() класса Order).
            //Так как полная информация о заказе хранится в базе данных в восьми таблицах, за один запрос сложно получить полную информацию,
            //тем более потом потребуется усложнять код для обработки полученных данных.
            //Учитывая вышесказанное, а также то, что такие запросы выполняются не настолько часто, чтобы нагрузить базу данных,
            //я принял решение использовать три запроса:
            $payments = Order::getPayments($id); //информация о платежах (содержит в себе также информацию о заказчике)
            $managers = Manager::getByOrderID($id); //информация о менеджерах, отвечающих за заказ
            $works = Work::getByOrderID($id); //информация о работах, выполненных по заказу

            //Соберем массив для преобразования в json строку и отправки браузеру
            $answer = ["payments" => $payments, "managers" => $managers, "works" => $works];
            echo json_encode($answer);
            exit;
        }
    }

    /**
     * Метод получает из базы данных список менеджеров и показывает страницу с формой поиска
     */
    public function actionForm($params){

        //Получим список менеджеров из базы данных
        $managers = Manager::getAll();        

        //отобразим страницу
        echo $this->render->renderPage('form.php', ['managers' => $managers]);
    }
}