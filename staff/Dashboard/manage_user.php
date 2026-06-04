<?php 
include("../../Includes/config.php"); 
session_start();
if(isset($_GET['id'])){
$registry = $con->query("SELECT * FROM registry where id =".$_GET['id']);
foreach($registry->fetch_array() as $k =>$v){
	$meta[$k] = $v;
}
}
?>
<div class="container-fluid">
	<div id="msg"></div>
	
	<form action="" id="manage-user">	
		<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
		<div class="form-group">
			<label for="visitor_name">Visitor Name</label>
			<input type="text" name="visitor_name" id="visitor_name" class="form-control" value="<?php echo isset($meta['visitor_name']) ? $meta['visitor_name']: '' ?>" required  autocomplete="off">
		</div>
		<div class="form-group">
			<label for="visitor_contact">Contact Number</label>
			<input type="text" name="visitor_contact" id="visitor_contact" class="form-control" value="<?php echo isset($meta['visitor_contact']) ? $meta['visitor_contact']: '' ?>" required  autocomplete="off">
		</div>
		<div class="form-group">
			<label for="host_id">Host Resident</label>
			<select name="host_id" id="host_id" class="custom-select select2" required>
				<option value=""></option>
				<?php
				$members = $con->query("SELECT * FROM member order by username asc");
				while($row=$members->fetch_assoc()):
				?>
				<option value="<?php echo $row['id'] ?>" <?php echo isset($meta['host_id']) && $meta['host_id'] == $row['id'] ? 'selected' : '' ?>><?php echo ucwords($row['username']) ?></option>
				<?php endwhile; ?>
			</select>
		</div>
		<div class="form-group">
			<label for="purpose">Purpose of Visit</label>
			<textarea name="purpose" id="purpose" class="form-control" required><?php echo isset($meta['purpose']) ? $meta['purpose']: '' ?></textarea>
		</div>
        <?php if(isset($meta['id'])): ?>
		<div class="form-group">
			<label for="status">Status</label>
			<select name="status" id="status" class="custom-select">
				<option value="Pending" <?php echo isset($meta['status']) && $meta['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
				<option value="Approved" <?php echo isset($meta['status']) && $meta['status'] == 'Approved' ? 'selected' : '' ?>>Approved</option>
				<option value="Rejected" <?php echo isset($meta['status']) && $meta['status'] == 'Rejected' ? 'selected' : '' ?>>Rejected</option>
				<option value="Completed" <?php echo isset($meta['status']) && $meta['status'] == 'Completed' ? 'selected' : '' ?>>Completed</option>
			</select>
		</div>
		<div class="form-group">
			<label for="out_time">Out Time (YYYY-MM-DD HH:MM:SS)</label>
			<input type="text" name="out_time" id="out_time" class="form-control" value="<?php echo isset($meta['out_time']) ? $meta['out_time']: '' ?>" autocomplete="off" placeholder="Leave blank if not left yet">
		</div>
		<?php endif; ?>
	</form>
</div>
<script>
	$('.select2').select2({
		placeholder:"Please select here",
		width:"100%"
	})
	
	$('#manage-user').submit(function(e){
		e.preventDefault();
		start_load()
		$.ajax({
			url:'ajax.php?action=save_user',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp ==1){
					alert_toast("Data successfully saved",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				}
				// else{
				// 	$('#msg').html('<div class="alert alert-danger">Username already exist</div>')
				// 	end_load()
				// }
			}
		})
	})	
</script>