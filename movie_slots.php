<?php

require_once 'DB.php';
$db = new DB();

if( isset($_POST['movie_slot']) ) {
	$db->movieSave($_POST['movie_slot']);
}

$movieSlots = $db->movieSlotGetAll();
$movieSlotsCount = 0;

$movieSlotTable = '';
while ($row = oci_fetch_assoc($movieSlots)) {
	$movieSlotTable .= "<tr>";
	$movieSlotTable .= "<td>" . $row['ID'] . "</td>";
	$movieSlotTable .= "<td>" . $row['NAME']  ."</td>";
	$movieSlotTable .= "<td>" . $row['MOVIE_ID'] ."</td>";
	$movieSlotTable .= "<td>" . $row['ROOM_ID'] ."</td>";
	$movieSlotTable .= "</tr>";
	$movieSlotsCount++;
}

$movies = $db->movieGetAll();
$moviesSelect = '<select id="movie" name="movie_slot[movie]">';
while ($row = oci_fetch_assoc($movies)) {
	$moviesSelect .= '<option value="'.$row['ID'].'">'.$row['TITLE'].'</option>';
}
$moviesSelect .= '</select>';

$rooms = $db->roomGetAll();
$roomsSelect = '<select id="room" name="movie_slot[room]">';
while ($row = oci_fetch_assoc($rooms)) {
	$roomsSelect .= '<option value="'.$row['ID'].'">'.$row['NAME'].'</option>';
}
$roomsSelect .= '</select>';

include 'header.php';
?>

<div class="container">
	<div class="row">
		<form class="col s12" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
			<div class="input-field col s12">
				<?php echo $moviesSelect ?>
				<label for="movie">Movie</label>
			</div>
			<div class="input-field col s12">
				<?php echo $roomsSelect ?>
				<label for="room">Room</label>
			</div>
			<div class="input-field col s12">
				<input name="movie_slot[start_at]" id="start_at" type="text" class="validate" required>
				<label for="start_at">Start at</label>
			</div>
	  		<div class="col s12 text-right">
		  		<button class="waves-effect waves-light btn" type="submit">Speichern</button>
		  	</div>
		</form>
	</div>

	<?php if( $movieSlotsCount ) : ?>
		<table>
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Movie ID</th>
					<th>Room ID</th>
				</tr>
			</thead>
			<tbody>
			<?php echo $movieSlotTable ?>
			</tbody>
		</table>
		
		<div class="count">Insgesamt <?php echo $movieSlotsCount; ?> Filme(s) gefunden!</div>
	<?php endif; ?>
</div>

<?php include 'footer.php' ?>