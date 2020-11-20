<?php
/*
* Класс для работы с бд
*
* @property mysqli db Подключение к бд
* @property string user Имя пользователя
* @property string pass Пароль
* @property string dbhost Имя хоста
* @property string dbname Название бд 
* @property MySql instance Экземпляр класса
* @property mysqli_result result Результат последнего запроса
*/

namespace AddressBook\Core\Db;

use Exception;

class MySql
{
    /*
    * Конструктор класса с открытием подключения
    * 
    * @param string user Имя пользователя
    * @param string pass Пароль
    * @param string dbhost Имя хоста
    * @param string dbname Название бд 
    *
    * @return void
    */
    private function __construct(string $user, string $pass, string $dbhost, string $dbname)
    {
        $this->user = $user;
        $this->pass = $pass;
        $this->dbhost = $dbhost;
        $this->dbname = $dbname;

        $this->connect();
    }

    private $db;

    /*
    * Подключение к бд
    * 
    * @return void
    */
    private function connect()
    {
        try {
            $this->db = mysqli_connect($this->dbhost, $this->user, $this->pass, $this->dbname);
            mysqli_set_charset($this->db, 'utf8');
        } catch (Exception $e) {
            die();
        }
    }

    private static $instance;

    /*
    * Получение экземляра класса
    * 
    * @param string user Имя пользователя
    * @param string pass Пароль
    * @param string dbhost Имя хоста
    * @param string dbname Название бд 

    * @return MySql
    */
    public static function getInstance($user = DB_USER, $pass = DB_PASS, $dbhost = DB_HOST, $dbname = DB_NAME): MySql
    {
        if (!self::$instance) {
            self::$instance = new MySql($user, $pass, $dbhost, $dbname);
        }

        return self::$instance;
    }

    /*
    * Получение id последней добавленной записи
    * 
    * @return int
    */
    public function getLastInsertedID(): int
    {
        return mysqli_insert_id($this->db);
    }

    /*
    * Выполнение запроса к бд
    *
    * @param string query Запрос
    * @param array param Параметры
    * 
    * @return mysqli_result | bool
    */
    public function execute(string $query, array $param = [])
    {
        $stmt = $this->setStatement($query, $param);
        $this->result = false;
        if ($stmt != NULL) {
            $stmt->execute();
            $this->result = $stmt->get_result();
        }

        return $this->result;
    }

    /*
    * Биндинг параметров к запросу
    *
    * @param string query Запрос
    * @param array param Параметры
    * 
    * @return mysqli_stmt | null
    */
    private function setStatement(string $query, array $param)
    {
        try {
            $stmt = $this->db->prepare($query);
            if (count($param) != 0) {
                $stmt->bind_param(...$param);
            }
        } catch (Exception $e) {
            if ($stmt != null) {
                $stmt->close();
            }
        }
        return $stmt;
    }

    /*
    * Чтение результата последнего запроса
    *
    * @return array | null
    */
    public function fetchResult()
    {
        if (!$this->result) {
            die();
        }

        $row = mysqli_fetch_assoc($this->result);

        return $row;
    }
}
