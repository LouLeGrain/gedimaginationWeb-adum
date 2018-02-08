<?
class Database
{
    private static $datasource = 'mysql:host=localhost; dbname=gedimagination';
    private static $username = 'root';
    private static $password = 'System2017';
    private static $db;

    public static function getDB()
    {
        if (!isset(self::$db)) {
            self::$db = new PDO(self::$datasource, self::$username, self::$password);
        }
        return self::$db;
    }
}
