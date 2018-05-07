<?php
namespace App\Core\F3;

use DB\SQL;
use DB\SQL\Mapper;

abstract class BaseModel
{
    use F3;

    protected $table;
    
    private $db;
    private $type;
    private $host;
    private $port;
    private $username;
    private $password;
    private $dbname;

    public function __construct()
    {

        $var = $this->base()->get('config.database');

        try {
            $this->type = $var['db'];
            $this->host = $var['db_host'];
            $this->port = $var['db_port'];
            $this->username = $var['db_user'];
            $this->password = $var['db_pass'];
            $this->dbname = $var['db_name'];
            $this->connect();
        } catch (\Exception $e) {
            echo "<pre>",$e->getMessage(),"</pre>";
            echo "<pre>",$e->getTraceAsString(),"</pre>";
            exit;
        }
    }

    private function connect()
    {
        $this->db = new SQL(
            "{$this->type}:{$this->host};port={$this->port};dbname={$this->dbname}",
            $this->username,
            $this->password
        );
    }

    protected function mapper()
    {
        return new Mapper($this->db, $this->table);
    }
}
