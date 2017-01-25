<?php

require_once 'DB.php';
$db = new DB();

if( isset($_POST['customer']) ) {
	$db->customerSave($_POST['customer']);
}

$customers = $db->customerGetAll();
$customersCount = 0;

$customersTable = '';
while ($row = oci_fetch_assoc($customers)) {
	$customersTable .= "<tr>";
	$customersTable .= "<td>" . $row['ID'] . "</td>";
	$customersTable .= "<td>" . $row['NAME']  ."</td>";
	$customersTable .= "<td>" . $row['EMAIL']  ."</td>";
	$customersTable .= "<td>" . $row['PASSWORD'] ."</td>";
	$customersTable .= "<td>" . $row['STREET'] ."</td>";
	$customersTable .= "<td>" . $row['ZIP'] ."</td>";
	$customersTable .= "<td>" . $row['CITY'] ."</td>";
	$customersTable .= "<td>" . $row['PERSON_ID'] ."</td>";
	$customersTable .= "</tr>";
	$customersCount++;
}

include 'header.php';
?>

<div class="container">
	<div class="row">
		<form class="col s12" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
			<div class="input-field col s12">
				<input name="customer[name]" autofocus id="customer_name" type="text" class="validate" required>
				<label for="customer_name">Name</label>
			</div>
			<div class="input-field col s12">
				<input name="customer[email]" id="customer_email" type="text" class="validate" required>
				<label for="customer_email">Email</label>
			</div>
			<div class="input-field col s12">
				<input name="customer[password]" id="customer_password" type="password" class="validate" required>
				<label for="customer_password">Passwort</label>
			</div>
			<div class="input-field col s12">
				<input name="customer[street]" id="customer_street" type="text" class="validate" required>
				<label for="customer_street">Strasse</label>
			</div>
			<div class="input-field col s12">
				<input name="customer[zip]" id="customer_zip" type="text" class="validate" required>
				<label for="customer_zip">ZIP</label>
			</div>
			<div class="input-field col s12">
				<input name="customer[city]" id="customer_city" type="text" class="validate" required>
				<label for="customer_city">City</label>
			</div>
		  <div class="col s12 text-right">
		  	<button class="waves-effect waves-light btn" type="submit">Speichern</button>
		  </div>
		</form>
	</div>

	<?php if( $customersCount ) : ?>
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
			<?php echo $customersTable ?>
			</tbody>
		</table>
		
		<div class="count">Insgesamt <?php echo $customersCount; ?> Kunden(s) gefunden!</div>
	<?php endif; ?>
</div>

<?php include 'footer.php' ?>