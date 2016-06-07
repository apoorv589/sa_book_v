<?php

$ui = new UI();

$row = $ui->row()->open();

$col1 = $ui->col()
->width(1)
->open();
$col1->close();

$col2 = $ui->col()
->width(10)
->open();


$box = $ui->box()
->uiType('primary')
->title('SAH Room Allotment Form')
->solid()
->open();

$form = $ui->form()
->multipart()
->action('sah_booking/room_allotment/insert_sah_allotment/'.$app_num)
->open();

$ui->input()
->placeholder('Application Number')
->type('text')
->label('Application Number')
->name('app_num')
->value($app_num)
->disabled()
->show();

$time_row = $ui->row()->open();
$ui->input()->width(6)
->type('text')
->label('Check In Time')
->name('check_in_display')
->value(date('j M Y g:i A', strtotime($check_in)))
->disabled()
->show();

$ui->input()->width(6)
->type('text')
->label('Check Out Time')
->name('check_out_display')
->value(date('j M Y g:i A', strtotime($check_out)))
->disabled()
->show();
$time_row->close();

$ui->input()
->type('hidden')
->name('check_in')
->id('check_in')
->value($check_in)
->show();
//->readable();

$ui->input()
->type('hidden')
->name('check_out')
->disabled()
->value($check_out)
//->readable()
->show();

if($est_ar_status==0)
{
	$total_room = $double_AC+$suite_AC;
}
else
{
	$total_room = 'No room left to be allocated.';
}
$ui->input()
//	->placeholder('Check Out Time')
->type('text')
->label('Total room to be allocated')
->name('room_total')
->disabled()
->value($total_room)
->show();

$room_type_row = $ui->row()->open();
$ui->input()->width(6)
//	->placeholder('Check Out Time')
->type('text')
->label('Double AC Rooms')
->name('double_AC')
->disabled()
->value($double_AC)
->show();

$ui->input()->width(6)
//	->placeholder('Check Out Time')
->type('text')
->label('Suite AC Rooms')
->name('suite_AC')
->disabled()
->value($suite_AC)
->show();
$room_type_row->close();

$ui->select()
->name('building')
->label('Select Building')
->addonLeft($ui->icon("bars"))
->required()
->options(array(
	$ui->option()->value()->text('Select')->disabled()->selected(),
	$ui->option()->value('old')->text('Old'),
	$ui->option()->value('extension')->text('Extension')))
->required()
->show();

$floor_box = $ui->row()->open();
	$col4 = $ui->col()
	->name('floor')
	->id('floor')
	->width(12)
	->open();
	$col4->close();
$floor_box->close();

?>
<center>
	<?
	$ui->button()
	->id('room_alloc_button')
	->value('Submit')
	->uiType('primary')
	->submit()
	->name('submit')
	->show();
	?>
</center>
<?
$form->close();

$box->close();

$col2->close();

$row->close();
?>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
	$(document).tooltip();
	$('select[name="building"]').change(function(){
		$('html, body').animate({
			scrollTop: $("#floor").offset().top
		}, 750);
	});
</script>