<?php

namespace app\models;

use app\engine\Db;
use app\engine\VarDump;


/**
 * Класс отвечает за работу с таблицей orders базы данных и обработку данных из этой таблицы
 * Class Order
 * @package app\models
 */
class Order extends Model
{
    public $id;
    public $customer_id;
    public $cost;
    public $comment;

    public function getId() {
        return $this->id;
    }

    public function getCustomerId() {
        return $this->customer_id;
    }

    public function getCost(){
        return $this->cost;
    }

    public function getComment() {
        return $this->comment;
    }

    /**
     * Метод ищет в базе данных заказы по данным заказчика (имя, фамилия, отчество)
     * Метод получает строку $name, и возвращает массив с заказами
     * Метод использует таблицы: заказы (orders), заказчики (customers), платежи (payments)
     */
    public static function getByCustomerName($name) {
        $sql = "SELECT orders.id, orders.cost, orders.comment, customers.name, customers.surname, customers.patronymic, SUM(payments.sum) as sum FROM orders
        LEFT JOIN customers ON customers.id = orders.customer_id
        LEFT JOIN payments ON payments.order_id = orders.id 
        WHERE customers.name REGEXP '{$name}' || customers.surname REGEXP '{$name}' || customers.patronymic REGEXP '{$name}'
        GROUP BY orders.id;";
        $orders = Db::getInstance()->queryAll($sql);
        return $orders;
    }

    /**
     * Метод ищет в базе данных и возвращает данные заказов, по данным заказчика (например адрес или телефон)
     * Метод получает строки $field и $value, и возвращает массив с заказами
     * Метод использует таблицы: заказы (orders), заказчики (customers), платежи (payments)
     */
    public static function getByCustomerField($field, $value) {
        $sql = "SELECT orders.id, orders.cost, orders.comment, customers.name, customers.surname, customers.patronymic, SUM(payments.sum) as sum FROM orders 
        LEFT JOIN customers ON customers.id = orders.customer_id
        LEFT JOIN payments ON payments.order_id = orders.id
        WHERE customers.{$field} REGEXP '{$value}'
        GROUP BY orders.id;";
        $orders = Db::getInstance()->queryAll($sql);
        return $orders;
    }

    /**
     * Метод ищет в базе данных и возвращает данные заказов, стоимость которых равна заданной
     * Метод получает строку $cost, и возвращает массив с заказами
     * Метод использует таблицы: заказы (orders), заказчики (customers), платежи (payments)
     */
    public static function getByCost($cost) {
        $sql = "SELECT orders.id, orders.cost, orders.comment, customers.name, customers.surname, customers.patronymic, SUM(payments.sum) as sum FROM orders 
        LEFT JOIN customers ON customers.id = orders.customer_id
        LEFT JOIN payments ON payments.order_id = orders.id
        WHERE orders.cost = '{$cost}'
        GROUP BY orders.id;";
        $orders = Db::getInstance()->queryAll($sql);
        return $orders;
    }

    /**
     * Метод ищет в базе данных и возвращает данные заказов, если в комментарии к заказу содержится искомая фраза
     * Метод получает строку $comment, и возвращает массив с заказами
     * Метод использует таблицы: заказы (orders), заказчики (customers), платежи (payments)
     */
    public static function getByComment($comment) {
        $sql = "SELECT orders.id, orders.cost, orders.comment, customers.name, customers.surname, customers.patronymic, SUM(payments.sum) as sum FROM orders 
        LEFT JOIN customers ON customers.id = orders.customer_id
        LEFT JOIN payments ON payments.order_id = orders.id
        WHERE orders.comment REGEXP '{$comment}'
        GROUP BY orders.id;";
        $orders = Db::getInstance()->queryAll($sql);
        return $orders;
    }
    
    /**
     * Метод ищет в базе данных и возвращает данные заказов, по id менеджера, который отвечает этот заказ
     * Метод получает строку $manager_id, и возвращает массив с заказами
     * Метод использует таблицы: заказы (orders), заказчики (customers), платежи (payments), менеджеры (managers), ордеры_менеджеры (orders_managers)
     */
    public static function getByManagerID($manager_id) {
        $sql = "SELECT orders.id, orders.cost, orders.comment, customers.name, customers.surname, customers.patronymic, SUM(payments.sum) as sum FROM orders 
        LEFT JOIN customers ON customers.id = orders.customer_id
        LEFT JOIN orders_managers ON orders.id = orders_managers.order_id
        LEFT JOIN managers ON managers.id = orders_managers.manager_id
        LEFT JOIN payments ON payments.order_id = orders.id
        WHERE managers.id = '{$manager_id}'
        GROUP BY orders.id;";
        $orders = Db::getInstance()->queryAll($sql);
        return $orders;
    }

    /**
     * Метод ищет в базе данных и возвращает данные заказов, по которым были платежи в определенную дату
     * Метод получает строку $date, и возвращает массив с заказами
     * Метод использует таблицы: заказы (orders), заказчики (customers), платежи (payments)
     */
    public static function getByPaymentDate($date) {
        $sql = "SELECT orders.id, orders.cost, orders.comment, customers.name, customers.surname, customers.patronymic, SUM(payments.sum) as sum FROM orders 
        LEFT JOIN customers ON customers.id = orders.customer_id
        LEFT JOIN payments ON payments.order_id = orders.id
        GROUP BY orders.id
        HAVING orders.id IN (
            SELECT orders.id FROM orders
            LEFT JOIN payments ON payments.order_id = orders.id
            WHERE payments.date = '{$date}'
            );";
        $orders = Db::getInstance()->queryAll($sql);
        return $orders;
    }

    /**
     * Метод ищет в базе данных и возвращает данные заказов, по которым сумма платежей менее, чем стоимость заказа
     * Метод получает строку $date, и возвращает массив с заказами
     * Метод использует таблицы: заказы (orders), заказчики (customers), платежи (payments)
     */
    public static function getDebtor() {
        $sql = "SELECT orders.id, orders.cost, orders.comment, customers.name, customers.surname, customers.patronymic, SUM(payments.sum) as sum FROM orders
        LEFT JOIN customers ON customers.id = orders.customer_id
        LEFT JOIN payments ON payments.order_id = orders.id
        GROUP BY orders.id
        HAVING sum < orders.cost || sum is NULL;";
        $orders = Db::getInstance()->queryAll($sql);
        return $orders;
    }

    /**
     * Метод ищет в базе данных и возвращает данные всех заказов
     * Метод использует таблицы: заказы (orders), заказчики (customers), платежи (payments)
     */
    public static function getAllOrders() {
        $sql = "SELECT orders.id, orders.cost, orders.comment, customers.name, customers.surname, customers.patronymic, SUM(payments.sum) as sum FROM orders
        LEFT JOIN customers ON customers.id = orders.customer_id
        LEFT JOIN payments ON payments.order_id = orders.id
        GROUP BY orders.id;";
        $orders = Db::getInstance()->queryAll($sql);
        return $orders;
    }

    /**
     * Метод ищет в базе данных и возвращает данные о рлатежах одного заказа.
     * Метод использует таблицы: заказы (orders), заказчики (customers), платежи (payments), виды платежей (payment_kinds).
     */
    public static function getPayments($id) {
        //Чтобы уменьшить количество запросов, сразу найдем данные о заказе, о заказчике и о платежах по заказу:
        $sql = "SELECT orders.id, orders.cost, orders.comment, customers.name, customers.surname, customers.patronymic, customers.address,
        customers.phone, payments.sum, payments.date, payments.payment_kind_id, payment_kinds.kind_name FROM orders
        LEFT JOIN customers ON customers.id = orders.customer_id
        LEFT JOIN payments ON payments.order_id = orders.id
        LEFT JOIN payment_kinds ON payment_kinds.id = payments.payment_kind_id
        WHERE orders.id = '{$id}';";
        $orders = Db::getInstance()->queryAll($sql);
        return $orders;
    }
    
}