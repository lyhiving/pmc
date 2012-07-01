<?php if ( ! defined('BASE_PATH')) exit('Access IS NOT allowed');
/**
 * 基础模型
 */
class model extends app{
    private   $connection;
    private   $connection_string;
    protected $db;

    /**
     * 构造方法
     */
    function __construct(){
        if( ! class_exists('Mongo') ) {
            exit("The MongoDB PECL extension has not been installed or enabled");
        }
        $this->connection_string();
        $this->connect();
    }

    /**
     * 连接MongoDB
     * @return int
     */
    private function connection_string()
    {
        $host   = trim(MONGO_HOST);
        $port   = trim(MONGO_PORT);
        $user   = trim(MONGO_USER);
        $pass   = trim(MONGO_PASS);
        $dbname = trim(MONGO_DB);

        $connection_string = "mongodb://";

        if( empty($host) ){
            exit("The Host must be set to connect to MongoDB");
        }

        if( empty($dbname) ){
            exit("The Database must be set to connect to MongoDB");
        }

        if( !empty($user) && !empty($pass) ) {
            $connection_string .= "{$user}:{$pass}@";
        }

        if( isset($port) && !empty($port) ) {
            $connection_string .= "{$host}:{$port}";
        } else {
            $connection_string .= "{$host}";
        }

        $this->connection_string = trim($connection_string);
    }

    /**
     * 初始化MongoDB
     * @return int
     */
    private function connect() {
        $dbname      = trim(MONGO_DB);
        $persist     = trim(MONGO_PERSIST);
        $persist_key = trim(MONGO_PERSIST_KEY);
        $options     = array();

        if( $persist === TRUE ){
            $options['persist'] = isset($persist_key) && !empty($persist_key) ? $persist_key : 'pmc_mongo_persist';
        }

        try {
            $this->connection = new Mongo($this->connection_string, $options);
            $this->db = $this->connection->{$dbname};
        } catch (MongoConnectionException $e) {
            exit("Unable to connect to MongoDB: {$e->getMessage()}");
        }
    }

    /**
     * 析构函数
     */
    public function __destruct(){
        $this->connection->close();
    }
}

// End app/lib/core/model.php