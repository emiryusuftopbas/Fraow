<?php
	class db{
		private $host;
		private $username; 
		private $password;
		private $dbname;
		private $charset;
		private $pdo;

		function __construct($host,$username,$password,$dbname,$charset = 'utf8')
		{
			$this->host = $host;
			$this->username = $username;
			$this->password = $password;
			$this->dbname = $dbname;
			$this->charset = $charset;
		}
		public function connect(){
			try{
				$dsn = "mysql:host=".$this->host.";dbname=".$this->dbname.";charset=".$this->charset;
				$this->pdo = new PDO($dsn, $this->username,$this->password);
				$this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				return $this->pdo;
			}catch(PDOException $e){
				print($e->getMessage());
			}
			
		}
		
	    public function disconnect(){
	    	$this->pdo = null;
	    }
	}
?>