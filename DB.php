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

    /**
     * Connect to database
     */
	public function connect()
	{
		$this->connection = oci_connect($this->dbUser, $this->dbPass, $this->dbName);
		if (!$this->connection) {
			echo "Unable to connect to database";
			exit;
		}
	}

    /**
     * Execute sql query
     *
     * @param $sql
     * @return resource
     */
	public function select($sql)
	{
		$stmt = oci_parse($this->connection, $sql);
  		oci_execute($stmt);
  		return $stmt;
	}

    /**
     * Perform sql statement
     *
     * @param $statement
     */
	public function execute($statement, $redirect = true)
	{
		$insert = oci_parse($this->connection, $statement);
   		oci_execute($insert);

		$conn_err = oci_error($this->connection);
		$insert_err = oci_error($insert);
		if(!$conn_err && !$insert_err){
			oci_free_statement($insert);
			if($redirect) {
				header('Location: '.$_SERVER['PHP_SELF']);
				die;
			}
		}
		else{
			echo '<pre>';
			var_dump($conn_err, $insert_err);
			oci_free_statement($insert);
			die;
		}
	}

	/**
     * Get all cinemas
     *
     * @param null $search
     * @return resource
     */
	public function cinemaGetAll($search = null)
	{
		if( $search ) {
			$command = 'SELECT * FROM cinemas WHERE name LIKE \''.$search.'\' ORDER BY id DESC';
		}
		else {
			$command = "SELECT * FROM cinemas ORDER BY id DESC";
		}

		return $this->select($command);
	}

	/**
     * Save cinema
     *
     * @param $cinema
     */
	public function cinemaSave($cinema)
	{
		$cinema = (object) $cinema;

		$cinema = array(
			'cinema_name' => isset($cinema->cinema_name) ? "'{$cinema->cinema_name}'" : '',
			'street' => isset($cinema->street) ? "'{$cinema->street}'" : '',
			'zip' => isset($cinema->zip) ? "{$cinema->zip}" : '',
			'city' => isset($cinema->city) ? "'{$cinema->city}'" : '',
		);

		$sql = 'INSERT INTO cinemas ('.(implode(array_keys($cinema), ',')).') VALUES ('.(implode(',', $cinema)).')';

		$this->execute($sql);
	}

	/**
     * Get all customers
     *
     * @param null $search
     * @return resource
     */
	public function customerGetAll($search = null)
	{
		if( $search ) {
			$command = 'SELECT c.email, c.password, c.person_id, c.name
						FROM customers c
						LEFT JOIN persons p ON p.id = c.person_id
						WHERE person.email LIKE \'%' . $search . '%\'
						ORDER BY c.id DESC';
		}
		else {
			$command = "SELECT c.*, p.name, p.street, p.zip, p.city
						FROM customers c
						LEFT JOIN persons p ON p.id = c.person_id
						ORDER BY c.id DESC";
		}

		return $this->select($command);
	}

	/**
     * Save customer
     *
     * @param $customer
     */
	public function customerSave($customer)
	{
		$customer = (object) $customer;

		$this->personSave($customer);

		$hashedPassword = isset($customer->password) ? md5($customer->password) : null;

		$customer = array(
			'email' => isset($customer->email) ? "'{$customer->email}'" : '',
			'password' => isset($customer->password) ? "'{$hashedPassword}'" : '',
			'person_id' => '(SELECT COUNT(id) from persons)'
		);

		$sql = 'INSERT INTO customers ('.(implode(array_keys($customer), ',')).') VALUES ('.(implode(',', $customer)).')';

		$this->execute($sql);
	}

	/**
     * Get all employees
     *
     * @param null $search
     * @return resource
     */
	public function employeeGetAll($search = null)
	{
		if( $search ) {
			$command = 'SELECT c.email, c.password, c.person_id, c.name
						FROM employees c
						LEFT JOIN persons p ON p.id = c.person_id
						WHERE person.email LIKE \'%' . $search . '%\'
						ORDER BY c.id DESC';
		}
		else {
			$command = "SELECT e.*, p.name, p.street, p.zip, p.city
						FROM employees e
						LEFT JOIN persons p ON p.id = e.person_id
						ORDER BY e.id DESC";
		}

		return $this->select($command);
	}

	/**
     * Save employee
     *
     * @param $employee
     */
	public function employeeSave($employee)
	{
		$employee = (object) $employee;

		$this->personSave($employee);

		$employee = array(
			'phone' => isset($employee->phone) ? "'{$employee->phone}'" : '',
			'social_security_nr' => isset($employee->social_security_nr) ? "'{$employee->social_security_nr}'" : '',
			'cinema_id' => isset($employee->cinema_id) ? "'{$employee->cinema_id}'" : '',
			'person_id' => '(SELECT COUNT(id) from persons)'
		);

		$sql = 'INSERT INTO employees ('.(implode(array_keys($employee), ',')).') VALUES ('.(implode(',', $employee)).')';

		$this->execute($sql);
	}

    /**
     * Get all movies
     *
     * @param null $search
     * @return resource
     */
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

		return $this->select($command);
	}

	/**
     * Save movie
     *
     * @param $movie
     */
	public function movieSave($movie)
	{
		$movie = (object) $movie;

		$movie = array(
			'title' => isset($movie->title) ? "'{$movie->title}'" : '',
			'duration' => isset($movie->duration) ? "{$movie->duration}" : '',
			'image' => isset($movie->image) ? "'{$movie->image}'" : '',
		);

		$sql = 'INSERT INTO movies ('.(implode(array_keys($movie), ',')).') VALUES ('.(implode(',', $movie)).')';

		$this->execute($sql);
	}

	/**
     * Get all movie slots
     *
     * @param null $search
     * @return resource
     */
	public function movieSlotGetAll($search = null)
	{
		if( $search ) {
			$command = 'SELECT c.email, c.password, c.person_id, c.name
						FROM movie_slots mc
						LEFT JOIN persons p ON p.id = c.person_id
						WHERE person.email LIKE \'%' . $search . '%\'
						ORDER BY c.id DESC';
		}
		else {
			$command = "SELECT * FROM movie_slots ORDER BY id DESC";
		}

		return $this->select($command);
	}

	/**
     * Save Slot
     *
     * @param $Slot
     */
	public function movieSlotSave($movieSlot)
	{
		$movieSlot = (object) $movieSlot;

		$movieSlot = array(
			'movie_id' => isset($movieSlot->movie_id) ? "'{$movieSlot->movie_id}'" : '',
			'room_id' => isset($movieSlot->room_id) ? "{$movieSlot->room_id}" : '',
			'start_at' => isset($movieSlot->start_at) ? "to_date('{$movieSlot->start_at}', 'YYYY-MM-DD HH24:MI','NLS_DATE_LANGUAGE=AMERICAN')" : '',
		);

		$sql = 'INSERT INTO movie_slots ('.(implode(array_keys($movieSlot), ',')).') VALUES ('.(implode(',', $movieSlot)).')';

		$this->execute($sql);
	}

	/**
     * Save person
     *
     * @param $person
     */
	public function personSave($person)
	{
		$person = (object) $person;

		$person = array(
			'street' => isset($person->street) ? "'{$person->street}'" : '',
			'zip' => isset($person->zip) ? "'{$person->zip}'" : '',
			'city' => isset($person->city) ? "'{$person->city}'" : '',
			'name' => isset($person->name) ? "'{$person->name}'" : '',
		);

		$sql = 'INSERT INTO persons ('.(implode(array_keys($person), ',')).') VALUES ('.(implode(',', $person)).')';

		return $this->execute($sql, false);
	}

	/**
     * Get all rooms
     *
     * @param null $search
     * @return resource
     */
	public function roomGetAll($search = null)
	{
		if( $search ) {
			$command = 'SELECT * FROM rooms c
						WHERE r.name LIKE \'%' . $search . '%\'
						ORDER BY r.id DESC';
		}
		else {
			$command = "SELECT * FROM rooms ORDER BY id DESC";
		}

		return $this->select($command);
	}

	/**
     * Save movie
     *
     * @param $movie
     */
	public function roomSave($room)
	{
		$room = (object) $room;

		$room = array(
			'cinema_id' => isset($room->cinema_id) ? "{$room->cinema_id}" : '',
			'name' => isset($room->name) ? "'{$room->name}'" : '',
		);

		$sql = 'INSERT INTO rooms ('.(implode(array_keys($room), ',')).') VALUES ('.(implode(',', $room)).')';

		$this->execute($sql);
	}

	/**
     * Get all tickets
     *
     * @param null $search
     * @return resource
     */
	public function ticketGetAll($search = null)
	{
		if( $search ) {
			$command = 'SELECT * FROM tickets c
						WHERE r.name LIKE \'%' . $search . '%\'
						ORDER BY r.id DESC';
		}
		else {
			$command = 'SELECT t.*, m.title AS movie_title, cp.name AS customer_name
						FROM tickets t
						LEFT JOIN movie_slots ms ON t.movie_slot_id = ms.id
						LEFT JOIN movies m ON m.id = ms.movie_id
						LEFT JOIN employees e ON e.id = t.employee_id
						LEFT JOIN customers c ON c.id = t.customer_id
						LEFT JOIN persons ep ON ep.id = e.person_id
						LEFT JOIN persons cp ON cp.id = c.person_id
						ORDER BY t.id DESC';

			// die($command);
		}

		return $this->select($command);
	}

	/**
     * Save ticket
     *
     * @param $ticket
     */
	public function ticketSave($ticket)
	{
		$ticket = (object) $ticket;

		$ticket = array(
			'customer_id' => isset($ticket->customer_id) ? "{$ticket->customer_id}" : '',
			'employee_id' => isset($ticket->employee_id) ? "{$ticket->employee_id}" : '',
			'movie_slot_id' => isset($ticket->movie_slot_id) ? "{$ticket->movie_slot_id}" : '',
			'price' => isset($ticket->price) ? "{$ticket->price}" : '',
			'seat' => isset($ticket->seat) ? "{$ticket->seat}" : '',
			'row_nr' => isset($ticket->row_nr) ? "{$ticket->row_nr}" : '',
			'purchased_at' => isset($ticket->purchased_at) ? "to_date('{$ticket->purchased_at}', 'YYYY-MM-DD HH24:MI','NLS_DATE_LANGUAGE=AMERICAN')" : 'NULL',
		);

		$sql = 'INSERT INTO tickets ('.(implode(array_keys($ticket), ',')).') VALUES ('.(implode(',', $ticket)).')';

		$this->execute($sql);
	}

}