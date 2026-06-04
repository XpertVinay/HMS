<?php 
include("../../Includes/config.php"); 
session_start();
if(isset($_GET['id'])){
$resident = $con->query("SELECT * FROM resident where id =".$_GET['id']);
foreach($resident->fetch_array() as $k =>$v){
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
		<div class="form-group">
			<label for="address">Address</label>
			<input type="text" name="address" id="address" class="form-control" value="<?php echo isset($meta['address']) ? $meta['address']: '' ?>">
		</div>
        <?php if(isset($meta['owner_noc']) && !empty($meta['owner_noc'])): ?>
            <div class="form-group">
                <label>Owner NOC / Rent Agreement</label><br>
                <a href="/uploads/<?php echo $meta['owner_noc']; ?>" target="_blank" class="btn btn-sm btn-info">View Document</a>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="is_rent_agreement_verified_admin" name="is_rent_agreement_verified_admin" value="1" <?php echo (isset($meta['is_rent_agreement_verified_admin']) && $meta['is_rent_agreement_verified_admin']) ? 'checked' : ''; ?>>
                <label class="custom-control-label" for="is_rent_agreement_verified_admin">Mark Rent Agreement as Visually Verified (Admin Level)</label>
            </div>
            <?php if(isset($meta['is_rent_agreement_verified_staff']) && $meta['is_rent_agreement_verified_staff']): ?>
                <small class="text-success"><i class='bx bx-check-circle'></i> Already verified by Staff</small>
            <?php else: ?>
                <small class="text-warning"><i class='bx bx-time'></i> Pending Staff Verification</small>
            <?php endif; ?>
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
			}
		})
	})	
</script>