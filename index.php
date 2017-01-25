<?php

require_once 'DB.php';
$db = new DB();

if( isset($_POST['movie']) ) {
	$db->movieSave($_POST['movie']);
}

// $movies = $db->movieGetAll();
// // $movieslots = $db->movieSlotGetAll();
// $customers = $db->customerGetAll();
// $employees = $db->employeeGetAll();
// $rooms = $db->roomGetAll();
$tickets = $db->ticketGetAll();
$ticketsCount = 0;

$ticketsTable = '';
while ($row = oci_fetch_assoc($tickets)) {
	$ticketsTable .= "<tr>";
	$ticketsTable .= "<td>" . $row['ID'] . "</td>";
	$ticketsTable .= "<td>" . $row['PURCHASED_AT']  ."</td>";
	$ticketsTable .= "<td>" . $row['SEAT'] ."</td>";
	$ticketsTable .= "<td>" . $row['MOVIE_TITLE'] ."</td>";
	$ticketsTable .= "<td>" . $row['MOVIE_NAME'] ."</td>";
	$ticketsTable .= "<td>" . $row['CUSTOMER_NAME'] ."</td>";
	$ticketsTable .= "</tr>";
	$ticketsCount++;
}


include 'header.php';
?>

<div class="container">
	<div class="row">
		<form class="col s12" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
			<div class="input-field col s12">
				<input name="movie[title]" autofocus id="movie_title" type="text" class="validate" required>
				<label for="movie_title">Titel</label>
			</div>
		  <div class="input-field col s12">
		      <input name="movie[image]" id="movie_image" type="text" class="validate" required>
		      <label for="movie_image">Bild</label>
		  </div>
		  <div class="input-field col s12">
		      <input name="movie[duration]" id="movie_duration" type="text" class="validate" required>
		      <label for="movie_duration">Dauer</label>
		  </div>
		  <div class="col s12 text-right">
		  	<button class="waves-effect waves-light btn" type="submit">Speichern</button>
		  </div>
		</form>
	</div>

	<?php if( $ticketsCount ) : ?>
		<table>
			<thead>
				<tr>
					<th>ID</th>
					<th>PURCHASED_AT</th>
					<th>SEAT</th>
					<th>MOVIE_TITLE</th>
					<th>MOVIE_NAME</th>
					<th>CUSTOMER_NAME</th>
				</tr>
			</thead>
			<tbody>
			<?php echo $ticketsTable ?>
			</tbody>
		</table>
		
		<div class="count">Insgesamt <?php echo $ticketsCount; ?> Filme(s) gefunden!</div>
	<?php endif; ?>
</div>

<?php include 'footer.php' ?>