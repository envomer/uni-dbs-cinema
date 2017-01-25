<?php

require_once 'DB.php';
$db = new DB();

if( isset($_POST['room']) ) {
	$db->roomSave($_POST['room']);
}

$rooms = $db->roomGetAll();
$roomsCount = 0;

$roomTable = '';
while ($row = oci_fetch_assoc($rooms)) {
	$roomTable .= "<tr>";
	$roomTable .= "<td>" . $row['ID'] . "</td>";
	$roomTable .= "<td>" . $row['NAME']  ."</td>";
	$roomTable .= "<td>" . $row['CINEMA_ID'] ."</td>";
	$roomTable .= "</tr>";
	$roomsCount++;
}

$cinemas = $db->cinemaGetAll();
$cinemaSelect = '<select id="cinema" name="room[cinema_id]">';
while ($row = oci_fetch_assoc($cinemas)) {
	$cinemaSelect .= '<option value="'.$row['ID'].'">'.$row['CINEMA_NAME'].'</option>';
}
$cinemaSelect .= '</select>';

include 'header.php';
?>

<div class="container">
	<div class="row">
		<form class="col s12" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
			<div class="input-field col s12">
				<?php echo $cinemaSelect ?>
				<label for="cinema">Cinema</label>
			</div>
			<div class="input-field col s12">
				<input name="room[name]" id="name" type="text" class="validate" required>
				<label for="name">Name</label>
			</div>
	  		<div class="col s12 text-right">
		  		<button class="waves-effect waves-light btn" type="submit">Speichern</button>
		  	</div>
		</form>
	</div>

	<?php if( $roomsCount ) : ?>
		<table>
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Cinema ID</th>
				</tr>
			</thead>
			<tbody>
			<?php echo $roomTable ?>
			</tbody>
		</table>
		
		<div class="count">Insgesamt <?php echo $roomsCount; ?> Filme(s) gefunden!</div>
	<?php endif; ?>
</div>

<?php include 'footer.php' ?>