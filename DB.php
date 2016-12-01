<?php

class DB
{
	protected $connection = null;
	protected $dbUser = 'a1267512';
	protected $dbPass = 'dbs16';
	protected $dbName = 'lab';

	public function __construct()
	{
		$this->connect();
	}

	public function connect()
	{
		// establish database connection
		$this->connection = oci_connect($this->dbUser, $this->dbPass, $this->dbName);
		if (!$this->connection) {
			echo "Unable to connect to database";
			exit;
		}
	}

	public function execute($sql)
	{
		$stmt = oci_parse($this->connection, $sql);
  		oci_execute($stmt);
  		return $stmt;
	}

	public function insert($statement)
	{
		$insert = oci_parse($this->connection, $statement);
   		oci_execute($insert);

		$conn_err = oci_error($this->connection);
		$insert_err = oci_error($insert);
		if(!$conn_err && !$insert_err){
			// inserted
			oci_free_statement($insert);
			header('Location: '.$_SERVER['PHP_SELF']);
			die;
		}
		else{
			echo '<pre>';
			var_dump($conn_err, $insert_err);
			oci_free_statement($insert);
			die;
		}
	}

	public function movieGetAll($search = null)
	{
		if( ! $search ) {
			$search = isset($_GET['search']) ? $_GET['search'] : null;
		}

		if( $search ) {
			$command = "SELECT * FROM movies WHERE title LIKE '%" . $search . "%' ORDER BY id DESC";
		}
		else {
			$command = "SELECT * FROM movies ORDER BY id DESC";
		}

		return $this->execute($command);
	}

	public function movieSave($movie)
	{
		$movie = (object) $movie;

		$movie = array(
			'id' => 'seq_movies_auto_increment.nextval',
			'title' => isset($movie->title) ? "'{$movie->title}'" : '',
			'duration' => isset($movie->duration) ? "{$movie->duration}" : '',
			'image' => isset($movie->image) ? "'{$movie->image}'" : '',
		);

		$sql = 'INSERT INTO movies ('.(implode(array_keys($movie), ',')).') VALUES ('.(implode(',', $movie)).')';

		$this->insert($sql);
	}

}