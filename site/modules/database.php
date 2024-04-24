<?php

class Database {
    private $db;

    public function __construct($path) {
        // Подключение к базе данных SQLite
        $this->db = new SQLite3($path);
    }

    public function Execute($sql) {
        // Выполнение SQL запроса без возврата результата
        $this->db->exec($sql);
    }

    public function Fetch($sql) {
        // Выполнение SQL запроса и возврат результата в виде ассоциативного массива
        $result = $this->db->query($sql);
        $data = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }

    public function Create($table, $data) {
        // Создание записи в таблице с данными из ассоциативного массива и возврат идентификатора созданной записи
        $keys = implode(',', array_keys($data));
        $values = "'" . implode("','", array_values($data)) . "'";
        $sql = "INSERT INTO $table ($keys) VALUES ($values)";
        $this->Execute($sql);
        return $this->db->lastInsertRowID();
    }

    public function Read($table, $id) {
        // Возврат записи из таблицы по идентификатору
        $sql = "SELECT * FROM $table WHERE id = $id";
        return $this->Fetch($sql);
    }

    public function Update($table, $id, $data) {
        // Обновление записи в таблице по идентификатору данными из ассоциативного массива
        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "$key = '$value'";
        }
        $set = implode(',', $set);
        $sql = "UPDATE $table SET $set WHERE id = $id";
        $this->Execute($sql);
    }

    public function Delete($table, $id) {
        // Удаление записи из таблицы по идентификатору
        $sql = "DELETE FROM $table WHERE id = $id";
        $this->Execute($sql);
    }

    public function Count($table) {
        // Возврат количества записей в таблице
        $sql = "SELECT COUNT(*) as count FROM $table";
        $result = $this->Fetch($sql);
        return $result[0]['count'];
    }
}

?>
