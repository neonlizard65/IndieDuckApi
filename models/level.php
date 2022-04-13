<?php

class Level{

    private $conn; //строка подключения
    private $table_name = 'Level'; //таблица

    public $LevelID;
    public $LevelNumber;
    public $LevelXP;
    public $CouponId;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    }

    // все
    function getLevels(){
        $query = "SELECT * FROM " . $this->table_name;
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }
}
?>