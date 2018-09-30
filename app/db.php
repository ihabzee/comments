<?php
/**
 * Created by PhpStorm.
 * User: Home
 * Date: 9/28/2018
 * Time: 9:17 PM
 */

namespace App;
abstract class DB{
    protected $db;

    /**
     * DB Type
     * @var string
     */
    private static $DBTYPE = 'mysql';

    /**
     * DB Host
     * @var string
     */
    private static $DBHOST = 'localhost';

    /**
     * DB Name
     * @var string
     */
    private static $DBNAME = 'tmbc';

    /**
     * DB User
     * @var string
     */
    private static $DBUSER = 'tmbc';

    /**
     * DB Password
     * @var string
     */
    private static $DBPASS = 'c1QPnZOAdOP4Fxes';


    /**
     * DB constructor.
     */
    public function __construct()
    {
        try {
          $this->db = new \PDO('' . self::$DBTYPE . ':host=' . self::$DBHOST . ';dbname=' . self::$DBNAME . '', self::$DBUSER, self::$DBPASS);
          $this->db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
          $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Message: ' . $e->getMessage();
        }
    }
}