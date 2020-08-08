<?php

namespace app\models;

use app\engine\Db;
use app\engine\VarDump;


/**
 * Класс отвечает за работу с таблицей managers (менеджеры) базы данных и обработку данных из этой таблицы
 * Class Manager
 * @package app\models
 */
class Manager extends Model
{
    public $id;
    public $name;

    /**
     * Метод возвращает название таблицы, которая в базе данных соответствует данному классу
     */
    public static function getTableName() {
        return "managers";
    }


    public function getId() {
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    /**
     * Метод ищет в базе данных и возвращает имена менеджеров по id заказа
     * Метод использует таблицы: заказы (orders), менджеры (managers) и заказы-менеджеры (orders_managers)
     */
    public static function getByOrderID($order_id) {
        $sql = "SELECT managers.name FROM orders
        LEFT JOIN orders_managers ON orders_managers.order_id = orders.id
        LEFT JOIN managers ON managers.id = orders_managers.manager_id
        WHERE orders.id = '{$order_id}';";
        $managers = Db::getInstance()->queryAll($sql);
        return $managers;
    }
}