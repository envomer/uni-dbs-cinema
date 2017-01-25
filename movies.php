<?php

require_once 'DB.php';
$db = new DB();

if( isset($_POST['movie']) ) {
	$db->movieSave($_POST['movie']);
}

$movies = $db->movieGetAll();
$moviesCount = 0;

$moviesTable = '';
while ($row = oci_fetch_assoc($movies)) {
	$moviesTable .= "<tr>";
	$moviesTable .= "<td>" . $row['ID'] . "</td>";
	$moviesTable .= "<td>" . $row['TITLE']  ."</td>";
	$moviesTable .= "<td>" . $row['IMAGE'] ."</td>";
	$moviesTable .= "<td>" . $row['DURATION'] ."</td>";
	$moviesTable .= "</tr>";
	$moviesCount++;
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

	<?php if( $moviesCount ) : ?>
		<table>
			<thead>
				<tr>
					<th>ID</th>
					<th>Titel</th>
					<th>Bild</th>
					<th>Laufzeit</th>
				</tr>
			</thead>
			<tbody>
			<?php echo $moviesTable ?>
			</tbody>
		</table>
		
		<div class="count">Insgesamt <?php echo $moviesCount; ?> Filme(s) gefunden!</div>
	<?php endif; ?>
</div>

<?php include 'footer.php'; ?>