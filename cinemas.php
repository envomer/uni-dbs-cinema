<?php

require_once 'DB.php';
$db = new DB();

if( isset($_POST['cinema']) ) {
	$db->cinemaSave($_POST['cinema']);
}

$cinemas = $db->cinemaGetAll();
$cinemasCount = 0;

$cinemasTable = '';
while ($row = oci_fetch_assoc($cinemas)) {
	$cinemasTable .= "<tr>";
	$cinemasTable .= "<td>" . $row['ID'] . "</td>";
	$cinemasTable .= "<td>" . $row['CINEMA_NAME']  ."</td>";
	$cinemasTable .= "<td>" . $row['STREET'] ."</td>";
	$cinemasTable .= "<td>" . $row['ZIP'] ."</td>";
	$cinemasTable .= "<td>" . $row['CITY'] ."</td>";
	$cinemasTable .= "</tr>";
	$cinemasCount++;
}

include 'header.php';
?>

<div class="container">
	<div class="row">
		<form class="col s12" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
			<div class="input-field col s12">
				<input name="cinema[cinema_name]" autofocus id="cinema_name" type="text" class="validate" required>
				<label for="cinema_name">Name</label>
			</div>
		  <div class="input-field col s12">
		      <input name="cinema[street]" id="cinema_street" type="text" class="validate" required>
		      <label for="cinema_street">Strasse</label>
		  </div>
		  <div class="input-field col s12">
		      <input name="cinema[zip]" id="cinema_zip" type="text" class="validate" required>
		      <label for="cinema_zip">ZIP</label>
		  </div>
		  <div class="input-field col s12">
		      <input name="cinema[city]" id="cinema_city" type="text" class="validate" required>
		      <label for="cinema_city">City</label>
		  </div>
		  <div class="col s12 text-right">
		  	<button class="waves-effect waves-light btn" type="submit">Speichern</button>
		  </div>
		</form>
	</div>

	<?php if( $cinemasCount ) : ?>
		<table>
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Strasse</th>
					<th>Zip</th>
					<th>City</th>
				</tr>
			</thead>
			<tbody>
			<?php echo $cinemasTable ?>
			</tbody>
		</table>
		
		<div class="count">Insgesamt <?php echo $cinemasCount; ?> Filme(s) gefunden!</div>
	<?php endif; ?>
</div>

<?php include 'footer.php'; ?>