<style>
	@media print {
  		a[href]:after {
    		content: none !important;
    	}
  	}
</style>

<?php
     // room booking history view

    $ui = new UI();

	//$day_time = 86400;
	$total_funds = 0;

    $row_guest_history = $ui->row()->open();
		$box_guest_history = $ui->box()
					  			->title('Guests Details')
								  ->solid()
								  ->uiType('primary')
								  ->open();

			  if(empty($booking_history)) {
				$ui->callout()
					->uiType('info')
					->title('No History Found')
					->desc("No booking details found  for entered details")
					->width(12)
					->show();
				}

			$table = $ui->table()->hover()->bordered()
							->sortable()->searchable()->paginated()
						    ->open();
			if(!empty($booking_history)) {

		?>
						<thead>
							<tr>
								<th>S. No.</th>
								<th>App.No.</th>
								<th>Name</th>
								<th>Address</th>
								<th>Rooms Allotted</th>
								<th>CheckIn</th>
								<th>CheckOut</th>
								<th>Contact </th>
								<th>Email ID</th>
								<th>Bill</th>
							</tr>
						</thead>

<?php
					$i=1;
					foreach($booking_history as $history)
					{
						$total_funds += $history['paid'];
?>
						<tr>

							<td><?=$i++?></td>
							<td><? echo '<a href="'.site_url("sah_booking/booking_request/details/".$history['app_num']."/".$auth).'">'.$history['app_num'].'</a>'; ?></td>
							<td><?=$history['name']?></td>
							<td><?=$history['address'] ?></td>
							<td><? if($history['rooms'])
										foreach($history['rooms'] as $_rooms)
											echo ucfirst($_rooms['building']).' - '.ucfirst($_rooms['floor']).' - '.$_rooms['room_no'].' - '.$_rooms['room_type'].'<br/>';
									else echo 'No Record!';
							?></td>
							<td><?=date('d M Y g:i a',strtotime($history['check_in']))?></td>
							<td>
							<?php
								if($history['check_out']!=NULL)
									echo date('d M Y g:i a',strtotime($history['check_out']));
								else
								{
								 echo '<p style= "color:red">Check_out Pending </p>';
								}
							?>
							</td>
							<td><?= $history['contact'] ?></td>
							<td><?= $history['email'] ?></td>
							<td><?
								if($history['paid'])
									echo $history['paid'];
								else echo '-';
							?></td>
						</tr>
					<? }
					}
			$table->close();
			if(!empty($booking_history))
			{
				echo '<br/>';
				$row = $ui->row()->open();
					$ui->col()->width(9)->open()->close();
					$col = $ui->col()->width(3)->open();
						$table = $ui->table()->open(); ?>
						<tr class="danger">
							<th>Total Funds</th>
							<td align="right"><?= $total_funds ?></td>
						</tr>
						<? $table->close();
					$col->close();
				$row->close();
			}
		$box_guest_history->close();
		$row_guest_history->close();

	?>
	<br/>
	<div class="row">
	<div class="col-md-5"></div>
	<div class="col-md-1"><button class="btn" id="btn_print">Print</button></div>
	<div class="col-md-5"></div>
</div>
<script>
	$(document).ready(function(){
		$('#btn_print').click(function(){
			$(this).hide();
			window.print();
			$(this).show();
		});

	});
</script>
