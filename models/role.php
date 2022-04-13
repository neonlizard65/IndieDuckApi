<?php

class Role{

    private $conn; //строка подключения
    private $table_name = 'Role'; //таблица

    public $RoleID;
    public $RoleName;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    }

    // все
    function getRoles(){
        $query = "SELECT * FROM " . $this->table_name;
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }
}
?>