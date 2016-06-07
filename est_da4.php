<?php
$ui = new UI();
//echo form_open('complaint/register_complaint/insert');
$row = $ui->row()->open();

$column1 = $ui->col()->width(1)->open();
$column1->close();

$column2 = $ui->col()->width(10)->open();
$box = $ui->box()
->solid()
->title("Application No. : ".$app_num)
->uiType('primary')
->open();

$form = $ui->form()->action('sah_booking/room_allotment/est_da4_action/'.$app_num)->open();

$table = $ui->table()->hover()
->open();
?>
<tr>
	<th>Applied By</th>
	<td><?= $user ?></td>
</tr>
<tr>
	<th><? $ui->icon("clock-o")->show() ?>Applied On</th>
	<td><?= $app_date ?></td>
</tr>
<tr>
	<th>Name</th>
	<td><?= $name ?></td>
</tr>
<tr>
	<th>Designation</th>
	<td><?= $designation ?></td>
</tr>
<tr>
	<th><? $ui->icon("clock-o")->show() ?> Check In</th>
	<td><?= $check_in ?></td>
</tr>
<tr>
	<th><? $ui->icon("clock-o")->show() ?> Check Out</th>
	<td><?= $check_out ?></td>
</tr>
<tr>
	<th> Number of Guests</th>
	<td><?= $no_of_guests ?></td>
</tr>
<tr>
	<th> Guest in Double AC Rooms (Preferred)</th>
	<td><?= $double_AC ?></td>
</tr>
<tr>
	<th> Guest in Suite AC Rooms (Preferred)</th>
	<td><?= $suite_AC ?></td>
</tr>
<? if($school_guest == '1') {?>
	<tr>
		<th>Approval Letter</th>
		<td><a href="<?= site_url('../assets/files/sah_booking/'.$user_id.'/'.$file_path) ?>">Click to view</a></td>
	</tr>
<? }
if($hod_status != 'Cancel' && $dsw_status != 'Cancel')
	{
	 ?>
	<th colspan="2" align="center">
	<center>
		<?
		$ui->button()
		->value('Allot Room')
		->submit(true)
		->id('allot_room')
		->uiType('primary')
		->show();
		?>
	</center>
	</th>
<? }
		$form->close();

		$table->close();

		$box->close();

		$column2->close();

		$row->close();
		?>
