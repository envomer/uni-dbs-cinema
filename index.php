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

?>

<!DOCTYPE html>
<html>
<head>
  <!--Import Google Icon Font-->
  <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.min.css">
  <link rel="stylesheet" href="style.css">

  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body>
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

	<!--Import jQuery before materialize.js-->
  <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/js/materialize.min.js"></script>
</body>
</html>