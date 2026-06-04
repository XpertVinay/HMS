<?php 
include("../../../Includes/config.php"); 
session_start();
if(isset($_GET['id'])){
$staff = $con->query("SELECT * FROM staff where id =".$_GET['id']);
foreach($staff->fetch_array() as $k =>$v){
	$meta[$k] = $v;
}
}
?>
<div class="container-fluid">
	<div id="msg"></div>
	
	<form action="" id="manage-user">	
		<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
		<div class="form-group">
			<label for="name">Email</label>
			<input type="email" name="email" id="email" class="form-control" value="<?php echo isset($meta['email']) ? $meta['email']: '' ?>" required>
		</div>
		<div class="form-group">
			<label for="username">Username</label>
			<input type="text" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username']: '' ?>" required  autocomplete="off">
		</div>
		<div class="form-group">
			<label for="mobile_number">Mobile Number</label>
			<input type="text" name="mobile_number" id="mobile_number" class="form-control" value="<?php echo isset($meta['mobile_number']) ? $meta['mobile_number']: '' ?>">
		</div>
        <?php if(isset($meta['employment_contract']) && !empty($meta['employment_contract'])): ?>
            <div class="form-group">
                <label>Employment Contract</label><br>
                <a href="/uploads/<?php echo $meta['employment_contract']; ?>" target="_blank" class="btn btn-sm btn-info">View Document</a>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="is_id_verified" name="is_id_verified" value="1" <?php echo (isset($meta['is_id_verified']) && $meta['is_id_verified']) ? 'checked' : ''; ?>>
                <label class="custom-control-label" for="is_id_verified">Mark ID as Visually Verified (Admin Level)</label>
            </div>
        </div>
		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" name="password" id="password" class="form-control" value="" autocomplete="off">
			<?php if(isset($meta['id'])): ?>
			<small><i>Leave this blank if you dont want to change the password.</i></small>
		<?php endif; ?>
		</div>
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