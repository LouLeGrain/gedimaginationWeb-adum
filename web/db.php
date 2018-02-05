<?
class Database
{
    private static $datasource = 'mysql:host=localhost; dbname=gedimagination';
    private static $username = 'gedimaginadmin';
    private static $password = 'jaipasdimagination';
    private static $db;

    public static function getDB()
    {
        if (!isset(self::$db)) {
            self::$db = new PDO(self::$datasource, self::$username, self::$password);
        }
        return self::$db;
    }
}
