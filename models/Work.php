<?php

namespace app\models;

use app\engine\Db;
use app\engine\VarDump;


/**
 * Класс отвечает за работу с таблицей works (работы) базы данных и обработку данных из этой таблицы
 * Class Work
 * @package app\models
 */
class Work extends Model
{
    public $id;
    public $order_id;
    public $work_kind_id;
    public $cost;


    public function getId() {
        return $this->id;
    }

    public function getOrderId(){
        return $this->order_id;;
    }

    public function getWorkKindId() {
        return $this->work_kind_id;
    }

    public function getCost(){
        return $this->cost;;
    }

    /**
     * Метод ищет в базе данных и возвращает работы, произведенные по одному заказу
     * Метод использует таблицы: заказы (orders), работы (works) и виды работ (work_kinds)
     */
    public static function getByOrderID($order_id) {
        $sql = "SELECT works.cost, work_kinds.title FROM works
        LEFT JOIN work_kinds ON work_kinds.id = works.work_kind_id
        WHERE works.order_id = '{$order_id}';";
        $managers = Db::getInstance()->queryAll($sql);
        return $managers;
    }

}