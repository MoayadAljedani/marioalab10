<?php 
class Database{
    private $dbHost;
    private $dbPort;
    private $dbName;
    private $dbUser;
    private $dbPassword;
    private $dbConnection;
    public function __constuct() {
        $this->dbHost =getenv('DB_HOST');
        $this->dbPort =getenv('DB_PORT');
        $this->dbName =getenv('DB_Name');
        $this->dbUser =getenv('DB_User');
        $this->dbPassword =getenv('DB_Password');
        if(!$this->dbHost || !$this->dbPort || !$this->dbName || !$this->dbUser || !$this->dbPassword){

            die("Set Database creds");

        }
    }
    public function connect() {
        try {
            $this->dbConnection = new PDO(
                'mysql:host=' . $this->dbHost . ';port=' . $this->dbPort . ';dbname=' . $this->dbName, $this->dbUser, $this->dbPassword
            );
            $this->dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection Error " . $e->getMessage());
        }
        return $this->dbConnection;
    }
    

}