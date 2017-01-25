<?php

require_once 'DB.php';
$db = new DB();

if( isset($_POST['employee']) ) {
	$db->employeeSave($_POST['employee']);
}

$employees = $db->employeeGetAll();
$employeesCount = 0;

$employeesTable = '';
while ($row = oci_fetch_assoc($employees)) {
	$employeesTable .= "<tr>";
	$employeesTable .= "<td>" . $row['ID'] . "</td>";
	$employeesTable .= "<td>" . $row['NAME']  ."</td>";
	$employeesTable .= "<td>" . $row['SOCIAL_SECURITY_NR']  ."</td>";
	$employeesTable .= "<td>" . $row['PHONE'] ."</td>";
	$employeesTable .= "<td>" . $row['STREET'] ."</td>";
	$employeesTable .= "<td>" . $row['ZIP'] ."</td>";
	$employeesTable .= "<td>" . $row['CITY'] ."</td>";
	$employeesTable .= "<td>" . $row['PERSON_ID'] ."</td>";
	$employeesTable .= "</tr>";
	$employeesCount++;
}

$cinemas = $db->cinemaGetAll();
$cinemaSelect = '<select id="cinema" name="employee[cinema_id]">';
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
				<input name="employee[name]" autofocus id="employee_name" type="text" class="validate" required>
				<label for="employee_name">Name</label>
			</div>
			<div class="input-field col s12">
				<input name="employee[social_security_nr]" id="employee_social_security_nr" type="text" class="validate" required>
				<label for="employee_social_security_nr">SvNr</label>
			</div>
			<div class="input-field col s12">
				<input name="employee[phone]" id="employee_phone" type="text" class="validate" required>
				<label for="employee_phone">Handy/Telephone</label>
			</div>
			<div class="input-field col s12">
				<input name="employee[street]" id="employee_street" type="text" class="validate" required>
				<label for="employee_street">Strasse</label>
			</div>
			<div class="input-field col s12">
				<input name="employee[zip]" id="employee_zip" type="text" class="validate" required>
				<label for="employee_zip">ZIP</label>
			</div>
			<div class="input-field col s12">
				<input name="employee[city]" id="employee_city" type="text" class="validate" required>
				<label for="employee_city">City</label>
			</div>
			<div class="input-field col s12">
				<?php echo $cinemaSelect ?>
				<label for="movie">Cinema</label>
			</div>
		  <div class="col s12 text-right">
		  	<button class="waves-effect waves-light btn" type="submit">Speichern</button>
		  </div>
		</form>
	</div>

	<?php if( $employeesCount ) : ?>
		<table>
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Email</th>
					<th>Passwort</th>
					<th>Strasse</th>
					<th>ZIP</th>
					<th>City</th>
					<th>Person ID</th>
				</tr>
			</thead>
			<tbody>
			<?php echo $employeesTable ?>
			</tbody>
		</table>
		
		<div class="count">Insgesamt <?php echo $employeesCount; ?> Kunden(s) gefunden!</div>
	<?php endif; ?>
</div>

<?php include 'footer.php' ?>