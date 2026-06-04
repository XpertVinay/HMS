<?php 

?>

<div class="container-fluid">
	
	<div class="row">
	<div class="col-lg-12">
			<button class="btn btn-primary float-right btn-sm" id="new_user"><i class="fa fa-plus"></i> New Person</button>
	</div>
	</div>
	<br>
	<div class="row">
		<div class="card col-lg-12">
			<div class="card-body">
				<table class="table table-striped table-bordered col-md-12">
			<thead>
				<tr>
					<th class="text-center">#</th>
					<th class="text-center">In Time</th>
					<th class="text-center">Visitor Name</th>
					<th class="text-center">Contact</th>
					<th class="text-center">Host Resident</th>
					<th class="text-center">Status</th>
					<th class="text-center">Out Time</th>
					<th class="text-center">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
 					// include ("../../Includes/config.php"); 
 					$registry = $con->query("SELECT r.*, m.username as host_name FROM registry r LEFT JOIN member m ON r.host_id = m.id ORDER BY r.created_at DESC");
 					$i = 1;
 					while($row= $registry->fetch_assoc()):
				 ?>
				 <tr>
				 	<td class="text-center">
				 		<?php echo $i++ ?>
				 	</td>
				 	<td>
				 		<?php echo date('M d, Y h:i A', strtotime($row['created_at'])) ?>
				 	</td>
				 	<td>
				 		<?php echo ucwords($row['visitor_name']) ?>
				 	</td>
				 	<td>
				 		<?php echo $row['visitor_contact'] ?>
				 	</td>
				 	<td>
				 		<?php echo ucwords($row['host_name']) ?>
				 	</td>
				 	<td>
                        <?php if($row['status'] == 'Pending'): ?>
                            <span class="badge badge-warning">Pending</span>
                        <?php elseif($row['status'] == 'Approved'): ?>
                            <span class="badge badge-success">Approved</span>
                        <?php elseif($row['status'] == 'Rejected'): ?>
                            <span class="badge badge-danger">Rejected</span>
                        <?php elseif($row['status'] == 'Completed'): ?>
                            <span class="badge badge-secondary">Completed</span>
                        <?php endif; ?>
                    </td>
				 	<td>
				 		<?php echo $row['out_time'] ? date('M d, Y h:i A', strtotime($row['out_time'])) : 'N/A' ?>
				 	</td>
				 	<td>
				 		<center>
								<div class="btn-group">
								  <button type="button" class="btn btn-primary">Action</button>
								  <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								    <span class="sr-only">Toggle Dropdown</span>
								  </button>
								  <div class="dropdown-menu">
								    <a class="dropdown-item edit_user" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>Edit</a>
                                    <?php if($row['status'] == 'Approved'): ?>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item update_status" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>' data-status='Completed'>Mark Completed</a>
                                    <?php endif; ?>
								    <div class="dropdown-divider"></div>
								    <a class="dropdown-item delete_user" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>Delete</a>
								  </div>
								</div>
								</center>
				 	</td>
				 </tr>
				<?php endwhile; ?>
			</tbody>
		</table>
			</div>
		</div>
	</div>

</div>
<script>
	$('table').dataTable();
$('#new_user').click(function(){
	uni_modal('New Person','manage_user.php')
})
$('.edit_user').click(function(){
	uni_modal('Edit Person','manage_user.php?id='+$(this).attr('data-id'))
})
$('.delete_user').click(function(){
		_conf("Are you sure to delete this person?","delete_user",[$(this).attr('data-id')])
	})
	function delete_user($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_user',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
	$('.update_status').click(function(){
		_conf("Are you sure to mark this visit as "+$(this).attr('data-status')+"?","update_status",[$(this).attr('data-id'), "'"+$(this).attr('data-status')+"'"])
	})
	function update_status($id, $status){
		start_load()
		$.ajax({
			url:'ajax.php?action=update_status',
			method:'POST',
			data:{id:$id, status:$status},
			success:function(resp){
				if(resp==1){
					alert_toast("Status successfully updated",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				}
			}
		})
	}
</script>