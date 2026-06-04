<div class="container-fluid">
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
					<th class="text-center">Purpose</th>
					<th class="text-center">Status</th>
					<th class="text-center">Out Time</th>
					<th class="text-center">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$host_id = $_SESSION['uid'] ?? $_SESSION['rid'] ?? 0;
 					$registry = $con->query("SELECT * FROM registry WHERE host_id = $host_id ORDER BY created_at DESC");
 					$i = 1;
 					while($row= $registry->fetch_assoc()):
				 ?>
				 <tr>
				 	<td class="text-center"><?php echo $i++ ?></td>
				 	<td><?php echo date('M d, Y h:i A', strtotime($row['created_at'])) ?></td>
				 	<td><?php echo ucwords($row['visitor_name']) ?></td>
				 	<td><?php echo $row['visitor_contact'] ?></td>
				 	<td><?php echo $row['purpose'] ?></td>
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
				 	<td><?php echo $row['out_time'] ? date('M d, Y h:i A', strtotime($row['out_time'])) : 'N/A' ?></td>
				 	<td>
				 		<center>
                            <?php if($row['status'] == 'Pending'): ?>
                                <button type="button" class="btn btn-sm btn-success update_status" data-id="<?php echo $row['id'] ?>" data-status="Approved">Approve</button>
                                <button type="button" class="btn btn-sm btn-danger update_status" data-id="<?php echo $row['id'] ?>" data-status="Rejected">Reject</button>
                            <?php else: ?>
                                <span class="text-muted">No action</span>
                            <?php endif; ?>
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
				} else {
                    alert_toast("Failed to update status",'danger')
                    setTimeout(function(){
                        location.reload()
                    },1500)
                }
			}
		})
	}
</script>
