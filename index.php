<?php

require_once 'DB.php';
$db = new DB();

if( isset($_POST['ticket']) ) {
	$db->ticketSave($_POST['ticket']);
}

$tickets = $db->ticketGetAll();
$ticketsCount = 0;

$ticketsTable = '';
while ($row = oci_fetch_assoc($tickets)) {
	$ticketsTable .= "<tr>";
	$ticketsTable .= "<td>" . $row['ID'] . "</td>";
	$ticketsTable .= "<td>" . $row['PURCHASED_AT']  ."</td>";
	$ticketsTable .= "<td>" . $row['SEAT'] ."</td>";
	$ticketsTable .= "<td>" . $row['ROW_NR'] ."</td>";
	$ticketsTable .= "<td>" . $row['MOVIE_SLOT_ID'] ."</td>";
	$ticketsTable .= "<td>" . $row['MOVIE_TITLE'] ."</td>";
	$ticketsTable .= "<td>" . $row['CUSTOMER_ID'] ."</td>";
	$ticketsTable .= "<td>" . $row['EMPLOYEE_ID'] ."</td>";
	$ticketsTable .= "<td>" . $row['PRICE'] ."</td>";
	$ticketsTable .= "</tr>";
	$ticketsCount++;
}

$movieSlots = $db->movieSlotGetAll();
$movieSlotsSelect = '<select id="movieSlot" name="ticket[movie_slot_id]">';
while ($row = oci_fetch_assoc($movieSlots)) {
	$movieSlotsSelect .= '<option value="'.$row['ID'].'">'.$row['ID'].'</option>';
}
$movieSlotsSelect .= '</select>';

$customers = $db->customerGetAll();
$customersSelect = '<select id="customer" name="ticket[customer_id]">';
while ($row = oci_fetch_assoc($customers)) {
	$customersSelect .= '<option value="'.$row['ID'].'">'.$row['NAME'].'</option>';
}
$customersSelect .= '</select>';

$employees = $db->employeeGetAll();
$employeesSelect = '<select id="employee" name="ticket[employee_id]">';
while ($row = oci_fetch_assoc($employees)) {
	$employeesSelect .= '<option value="'.$row['ID'].'">'.$row['NAME'].'</option>';
}
$employeesSelect .= '</select>';

include 'header.php';
?>

<div class="container">
	<div class="row">
		<form class="col s12" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
		  <div class="input-field col s12">
		      <input name="ticket[price]" autofocus id="ticket_price" type="text" class="validate" required>
		      <label for="ticket_price">Price</label>
		  </div>
			<div class="input-field col s12">
				<input name="ticket[seat]" id="ticket_seat" type="text" class="validate" required>
				<label for="ticket_seat">Sitz</label>
			</div>
			<div class="input-field col s12">
				<input name="ticket[row_nr]" id="ticket_row_nr" type="text" class="validate" required>
				<label for="ticket_row_nr">Reihe</label>
			</div>
			<div class="input-field col s12">
				<?php echo $movieSlotsSelect ?>
				<label for="ticket_movie_id">Movie</label>
			</div>
		  <div class="input-field col s12">
		      <?php echo $customersSelect ?>
		      <label for="ticket_customer_id">Customer</label>
		  </div>
		  <div class="input-field col s12">
		      <?php echo $employeesSelect ?>
		      <label for="ticket_employee_id">Employee</label>
		  </div>
			<div class="input-field col s12">
				<input name="ticket[purchased_at]" id="purchased_at" type="text" class="validate" required value="<?php echo date('Y-m-d H:i') ?>">
				<label for="purchased_at">Gekauft am</label>
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
					<th>Gekauft am</th>
					<th>Sitz</th>
					<th>Reihe</th>
					<th>Veranstaltung ID</th>
					<th>Movie name</th>
					<th>Kunde ID</th>
					<th>Angesteller ID</th>
					<th>Preis</th>
				</tr>
			</thead>
			<tbody>
			<?php echo $ticketsTable ?>
			</tbody>
		</table>
		
		<div class="count">Insgesamt <?php echo $ticketsCount; ?> Ticket(s) gefunden!</div>
	<?php endif; ?>
</div>

<?php include 'footer.php' ?>