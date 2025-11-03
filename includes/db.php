<?php
/**
 * Database Connection Handler
 * Uses PDO for secure database operations
 */

class Database {
    private static $instance = null;
    private $connection;
    
    // Database configuration
    private $host = 'localhost';
    private $dbname = 'smartbuild_construction';
    private $username = 'root';
    private $password = '';
    private $charset = 'utf8mb4';
    
    private function __construct() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            
            $this->connection = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    // Prevent cloning of instance
    private function __clone() {}
    
    // Prevent unserialization of instance
    public function __wakeup() {
        throw new Exception("Cannot unserialize singleton");
    }
}

/**
 * Get database connection
 */
function getDB() {
    return Database::getInstance()->getConnection();
}

/**
 * Execute a query and return all results
 */
function query($sql, $params = []) {
    $db = getDB();
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

/**
 * Execute a query and return single result
 */
function queryOne($sql, $params = []) {
    $db = getDB();
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetch();
}

/**
 * Execute an insert/update/delete query
 */
function execute($sql, $params = []) {
    $db = getDB();
    $stmt = $db->prepare($sql);
    return $stmt->execute($params);
}

/**
 * Get last inserted ID
 */
function lastInsertId() {
    return getDB()->lastInsertId();
}

/**
 * Begin transaction
 */
function beginTransaction() {
    return getDB()->beginTransaction();
}

/**
 * Commit transaction
 */
function commit() {
    return getDB()->commit();
}

/**
 * Rollback transaction
 */
function rollback() {
    return getDB()->rollBack();
}
