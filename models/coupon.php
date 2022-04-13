<?php

class Coupon{

    private $conn; //строка подключения
    private $table_name = 'Coupon'; //таблица

    public $CouponID;
    public $CouponName;
    public $DiscountPercent;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    }

    // все
    function getCoupons(){
        $query = "SELECT * FROM " . $this->table_name;
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }
}
?>