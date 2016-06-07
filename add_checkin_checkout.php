<?php
	$ui = new UI();
	$room_string = "";
	$drop_down = array();
	$room_mapping = array();
	$app_num;
	$i=1;
	// making of droup down menu & room no string
	if($rooms_left)
	{
		foreach($rooms as $room)
		{
			$room_mapping[$room['id']] = ucfirst($room['building'])." - ".ucfirst($room['floor'])." - ".$room['room_no'];
			$room_string = $room_string.$room_mapping[$room['id']]."</br>";
			$drop_down[$i++] = $ui->option()->value($room['id'])->text(ucfirst($room['building'])." - ".ucfirst($room['floor'])." - ".$room['room_no'].' - '.ucfirst($room['room_type']));
		}
	}
	$no_of_guests=0;
	foreach($app_details as $app_detail)
	{

		$column_blank = $ui->col()->width(1)->open()->close();

		$no_of_guests = $app_detail['no_of_guests'];

		$column_main = $ui->col()->width(10)->open();
		$row_app_details = $ui->row()->open();
		$app_num = $app_detail['app_num'];
		$box = $ui->box()
				  ->solid()
				  ->id('app_detail_box')
				  ->title("Application No. : ".$app_detail['app_num'])
				  ->uiType('primary')
				  ->open();
		echo '<div id="app_info">';
			$table = $ui->table()->hover()
						->open();
	?>
				<tr>
					<th><? $ui->icon("clock-o")->show() ?>Applied On</th>
					<td><?= $app_detail['app_date'] ?></td>
				</tr>
				<tr>
					<th>Purpose of Visit</th>
					<td><?= $app_detail['purpose_of_visit']?></td>
				</tr>
				<tr>
					<th>Applicant Name</th>
					<td><?= $app_detail['name'] ?></td>
				</tr>
				<tr>
					<th>Designation</th>
					<td><?= $app_detail['designation'] ?></td>
				</tr>
				<tr>
					<th><? $ui->icon("clock-o")->show() ?> Check In</th>
					<td><?= $app_detail['check_in'] ?></td>
				</tr>
				<tr>
					<th><? $ui->icon("clock-o")->show() ?> Check Out</th>
					<td><?= $app_detail['check_out'] ?></td>
				</tr>
				<tr>
					<th>Number of Guests</th>
					<td><?= $app_detail['no_of_guests'] ?></td>
				</tr>
					<? if($no_of_rooms > 0) { ?>
				<tr>
					<th>Rooms allotted</th>
					<td><? foreach($room_booking_details as $room) echo ucfirst($room->building).' - '.ucfirst($room->floor).' - '.$room->room_no.' - '.$room->room_type.'<br />'; ?></td>
				</tr>
					<? }?>

				<tr>
					<th>Whether School Guest?</th>
					<td><?if ($app_detail['school_guest'] == '1') echo "Yes"; else echo "No";  ?></td>
				</tr>
				<? if ($app_detail['school_guest'] == '1') { ?>
				<tr>
					<th>Approval Letter</th>
					<td><a href="<?= site_url('../assets/files/sah_booking/'.$this->session->userdata('id').'/'.$app_detail['file_path']) ?>">Click to view Approval Letter</a></td>
				</tr>
				<? } ?>
		<?php

			$table->close();
			echo '</div>';
			$box->close();
			$row_app_details->close();

	}

	if(count($guest_details)!=0){
		$row_guest_details = $ui->row()->open();
		$box_guest_details = $ui->box()
					  			->title('Guest Details')
								  ->solid()
								  ->uiType('primary')
								  ->open();
		$table = $ui->table()->hover()->bordered()
								->sortable()->searchable()->paginated()
							    ->open();
		?>
								<thead>
									<tr>
										<th>S. No.</th>
										<th>Name</th>
										<th>No. of Guests</th>
										<th>Rooms Allotted</th>
										<th>ID Card</th>
										<th>CheckIn</th>
										<th>CheckOut</th>
										<th>Receipt</th>
									</tr>
								</thead>

		<?php

							$i=1;
							foreach($guest_details as $guest)
							{
		?>
								<tr>

									<td><?=$i++?></td>
									<td><a href="<?= site_url('sah_booking/guest_details/show_guest_details/'.$user_id.'/'.$app_detail['app_num'].'/'.$guest['name'].'/'.$guest['check_in']) ?>"><?=$guest['name']?></a></td>
									<td><?=$guest['no_of_guests']?></td>
									<td><? foreach($guest['rooms'] as $room)
												if($room != 'Room Info Unavailable!')
													echo $room.'<br/>';
										   		else echo $room.'<br/>'; ?></td>
									<td><a href="<?= site_url('../assets/files/sah_booking/'.$user_id.'/'.$guest['identity_card']) ?>">View ID</a></td>
									<td><?=date('d M Y g:i a',strtotime($guest['check_in']))?></td>
									<td
									<?php
										if($guest['check_out']!=NULL)
											echo '>'.date('d M Y g:i a',strtotime($guest['check_out']));
										else
										{
										?>
											align="center"><a href="../add_checkout/<?=$app_num?>/<?=$guest['room_alloted']?>/<?=$guest['name']?>"><?=$ui->button()->icon($ui->icon('remove'))->mini()->uiType('danger')->value('CheckOut')->show();?></a>
										<?php
										}
									?>
									</td>
									<td><?
										if($guest['paid'] === NULL) {
											$function_string = 'generate_bill';
											$bill_string = 'View Bill';
										}
										else {
											$function_string = 'generate_receipt';
											$bill_string = 'View Receipt';
										}
										if($guest['check_out']!=NULL)
											echo '<a href="../'.$function_string.'/'.$app_num.'/'.$guest['name'].'/'.$guest['check_in'].'" name="receipt" >'.$bill_string.'</a>';
										else echo 'Checkout Pending'; ?></td>
								</tr>
							<? }

							$table->close();
		$box_guest_details->close();
		$row_guest_details->close();
	}

	if($count_guest != $no_of_guests)
	{
		$row_add_checkin = $ui->row()->open();
		$box = $ui->box()
				  ->title('Add Guest Checkin')
				  ->solid()
				  ->uiType('primary')
				  ->open();
		?>
		<ul class="nav nav-tabs nav-justified">
	  		<li class="active"><a data-toggle="tab" href="#group">Group</a></li>
	  		<li ><a data-toggle="tab" href="#individual">Individual</a></li>
		</ul>
		<br />
		<div class="tab-content">
			<div id="group" class="tab-pane fade in active">
				<? $form = $ui->form()->multipart()->action('sah_booking/guest_details/insert_guest/')->open();
				echo '<input type="hidden" name="type_of_booking" value="group">';
				echo '<input type="hidden" name="app_num" value="'.$app_num.'">';
				$inputRow1 = $ui->row()->open();
					$ui->input()
					   ->type('text')
					   ->label('Name<span style= "color:red;"> *</span>')
					   ->name('name')
					   ->required()
					   ->width(6)
					   ->show();
				 	$ui->input()
				       ->type('text')
				   	   ->label('Designation')
				       ->name('designation')
				   	   ->width(6)
				       ->show();
				$inputRow1->close();
				$inputRow2 = $ui->row()->open();
					 $ui->input()
					 	->type('text')
					    ->label('Address<span style= "color:red;"> *</span>')
						->name('address')
						->width(6)
						->required()
						->show();
					$ui->select()
					    ->label('Gender<span style= "color:red;"> *</span>')
						->name('gender')
						->options(array($ui->option()->value('m')->text('Male'),
										$ui->option()->value('f')->text('Female')))
						->width(6)
						->required()
						->show();
				$inputRow2->close();

				$contact_row = $ui->row()->open();
					$ui->input()
					    ->label('Contact Number<span style= "color:red;"> *</span>')
						->name('contact')
						->width(6)
						->required()
						->show();
					$ui->input()
					    ->label('Email ID<span style= "color:red;"> *</span>')
						->name('email')
						->width(6)
						->required()
						->show();
				$contact_row->close();

				$inputRow3 = $ui->row()->open();
					$checkbox_col = $ui->col()->width(6)->open();
					echo '<label for="ckbox_rooms[]">Select Rooms</label><br/>';
					if($rooms_left)
						foreach($rooms as $room)
						{
							echo '<input type="checkbox" name="ckbox_rooms[]" value="'.$room['id'].'">'.ucfirst($room['building']).' - '.ucfirst($room['floor']).' - '.$room['room_no'].' - '.ucfirst($room['room_type']).'<br/>';
							echo '<input type="hidden" id="ckbox'.$room['id'].'" value="'.$room['room_type'].'">';
						}
					else echo 'Requested Rooms Full!';
					echo '<br/>';
					$checkbox_col->close();

					foreach($app_details as $app_detail)
					{
						for($i = 1; $i <= $app_detail['no_of_guests'] - $count_guest; $i++)
							$guest_no[$i] =  $ui->option()->value($i)->text($i);
					}
					$ui->select()
						->label('No. of Guests')
						->name('group_guests')
						->options($guest_no)
						->width(6)
						->required()
						->show();
				$inputRow3->close();
				$inputRow4 = $ui->row()->open();
					$ui->input()
					 	->type('file')
					    ->label('Upload Identity Card')
						->name('identity_card')
						->required()
						->width(12)
						->show();
				$inputRow4->close();
				echo '<center>';
					$ui->button()
						->value('Add Checkin')
					    ->uiType('primary')
						->icon($ui->icon('plus'))
					    ->submit()
					    ->name('ckbox_btn')
					    ->show();
				echo '</center>';
				$form->close();

			echo '</div><div id="individual" class="tab-pane fade">';

				$form = $ui->form()->multipart()->action('sah_booking/guest_details/insert_guest/')->open();
				//$form = $ui->form()->multipart()->action('sah_booking/guest_details/check/')->open();

				echo '<input type="hidden" name="type_of_booking" value="individual">';
				echo '<input type="hidden" name="app_num" value="'.$app_num.'">';
				$inputRow1 = $ui->row()->open();
					$ui->input()
					   ->type('text')
					   ->label('Name<span style= "color:red;"> *</span>')
					   ->name('name')
					   ->required()
					   ->width(6)
					   ->show();
				 	$ui->input()
				       ->type('text')
				   	   ->label('Designation')
				       ->name('designation')
				   	   ->width(6)
				       ->show();
				$inputRow1->close();
				$inputRow2 = $ui->row()->open();
					 $ui->input()
					 	->type('text')
					    ->label('Address<span style= "color:red;"> *</span>')
						->name('address')
						->required()
						->width(6)
						->show();
					$ui->select()
					    ->label('Gender<span style= "color:red;"> *</span>')
						->name('gender')
						->options(array($ui->option()->value('m')->text('Male'),
										$ui->option()->value('f')->text('Female')))
						->width(6)
						->required()
						->show();
				$inputRow2->close();

				$contact_row = $ui->row()->open();
					$ui->input()
					    ->label('Contact Number<span style= "color:red;"> *</span>')
						->name('contact')
						->width(6)
						->required()
						->show();
					$ui->input()
					    ->label('Email ID<span style= "color:red;"> *</span>')
						->name('email')
						->width(6)
						->required()
						->show();
				$contact_row->close();

				$inputRow3 = $ui->row()->open();
					if($rooms_left)
						$ui->select()
					    ->label('Select Room<span style= "color:red;"> *</span>')
						->name('room_alloted')
						->options($drop_down)
						->width(6)
						->required()
						->show();
					else
					{
						$col = $ui->col()->width(6)->open();
							echo '<label for="room_full">Select Rooms</label>';
							echo '<p name="room_full">Requested Rooms Full!</p>';
						$col->close();
					}
				$inputRow3->close();
				echo '<br/>';
				$inputRow4 = $ui->row()->open();
					$ui->input()
					 	->type('file')
					    ->label('Upload Identity Card')
						->name('identity_card')
						->required()
						->width(12)
						->show();
				$inputRow4->close();
				echo '<center>';
				 	$ui->button()
					->value('Add Checkin')
				    ->uiType('primary')
					->icon($ui->icon('plus'))
				    ->submit()
				    ->name('drpdwn_btn')
				    ->show();
				echo '</center>';
				$form->close();
			echo '</div></div>';

		$row_add_checkin->close();
	}

	$column_main->close();
?>

<script type="text/javascript">
	$(document).ready(function(){

		var no_of_guests = parseInt($('select[name="group_guests"]').val());
		var total_selected = 0;

		$('select[name="group_guests"]').change(function(){
			no_of_guests = parseInt($(this).val());
		});

		$('input').on('ifChanged', function(){
			var hidden_id = this.value;
			var select_value = 0;
			if($('#ckbox' + hidden_id).val() == "Double Bedded AC")
				select_value = 2;
			else select_value = 1;

			if(this.checked)
				total_selected += select_value;
			else
				total_selected -= select_value;

			if(total_selected == no_of_guests || total_selected == no_of_guests + 1)
				$('input[type=checkbox]').not(':checked').attr('disabled', true);
			else $('input').not(':checked').attr('disabled', false);
		});

		$('#app_detail_box').click(function(){
			$('#app_info').slideToggle();
		});

		$('[name="name"]').change(function(){
			if(/[^a-z ]/i.test($(this).val()))
			{
				alert('Only Alphabets allowed!');
				$(this).val('');
			}
		});

		$('[name="designation"]').change(function(){
			if(/[^a-z ]/i.test($(this).val()))
			{
				alert('Only Alphabets allowed!');
				$(this).val('');
			}
		});

		$('[name="contact"]').change(function(){
			if(/[^0-9 ]/.test($(this).val()))
			{
				alert("Please enter numbers only!");
				$(this).val('');
			}
		});

		$('[name="email"]').change(function(){
			var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
			if(!re.test($(this).val()))
			{
				alert("Please enter proper email address!");
				$(this).val('');
			}
		});

		$('[name="group_guests"]').change(function(){
			$('input[type=checkbox]:checked').iCheck("uncheck");
		});

		$('[name="ckbox_btn"]').click(function(){
			var checked = $('input[type=checkbox]:checked').length;
			if(!checked){
				alert("Select atleast one room!");
				return false;
			}
		});

		$('[name="drpdwn_btn"]').click(function(){
			if(!$('[name="room_alloted"]').val()){
				alert("Select atleast one room!");
				return false;
			}
		});
	});

</script>
