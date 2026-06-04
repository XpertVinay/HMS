<?php include('header.php') ?>
<div class="container-fluid">
	
	<div class="row">
	<div class="col-lg-12">
			<button class="btn btn-primary float-right btn-sm" id="new_property"><i class="fa fa-plus"></i> New Property</button>
	</div>
	</div>
	<br>
	<div class="row">
		<div class="card col-lg-12">
			<div class="card-body">
				<table class="table-striped table-bordered col-md-12" id="property-list">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">Address / Unit</th>
							<th class="text-center">Type</th>
							<th class="text-center">Owner</th>
							<th class="text-center">Current Resident</th>
							<th class="text-center">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
 							include '../../Includes/Database.php';
                            $db = Database::getInstance();
                            $con = $db->getConnection();
                            
                            $org_id = ACTIVE_ORG_ID;
 							$properties = $con->query("
                                SELECT p.*, 
                                       m.username as owner_name,
                                       r.username as resident_name 
                                FROM property p
                                LEFT JOIN member m ON p.owner_id = m.id
                                LEFT JOIN resident r ON p.resident_id = r.id
                                WHERE p.organization_id = $org_id
                                ORDER BY p.address ASC
                            ");
 							$i = 1;
 							while($row= $properties->fetch_assoc()):
						 ?>
						 <tr>
						 	<td class="text-center">
						 		<?php echo $i++ ?>
						 	</td>
						 	<td>
						 		<b><?php echo htmlspecialchars($row['address']) ?></b>
						 	</td>
						 	<td>
						 		<b><?php echo htmlspecialchars($row['type']) ?></b>
						 	</td>
						 	<td>
						 		<b><?php echo htmlspecialchars($row['owner_name'] ?? 'N/A') ?></b>
						 	</td>
						 	<td>
						 		<b><?php echo htmlspecialchars($row['resident_name'] ?? 'N/A') ?></b>
						 	</td>
						 	<td class="text-center">
		                        <button class="btn btn-primary btn-sm edit_property" type="button" data-id="<?php echo $row['id'] ?>"><i class="fa fa-edit"></i> Edit</button>
		                        <button class="btn btn-danger btn-sm delete_property" type="button" data-id="<?php echo $row['id'] ?>"><i class="fa fa-trash"></i> Delete</button>
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
	$(document).ready(function(){
		$('#property-list').dataTable()
	})
	$('#new_property').click(function(){
		uni_modal("New Property","manage_user.php")
	})
	$('.edit_property').click(function(){
		uni_modal("Edit Property","manage_user.php?id="+$(this).attr('data-id'))
	})
	$('.delete_property').click(function(){
		_conf("Are you sure to delete this property?","delete_property",[$(this).attr('data-id')])
	})
	function delete_property($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_property',
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
</script>