<?php 
include("../../Includes/config.php"); 
session_start();
if(isset($_GET['id'])){
$vendor = $con->query("SELECT * FROM vendor where id =".$_GET['id']);
foreach($vendor->fetch_array() as $k =>$v){
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
			<label for="business_name">Business Name</label>
			<input type="text" name="business_name" id="business_name" class="form-control" value="<?php echo isset($meta['business_name']) ? $meta['business_name']: '' ?>" required  autocomplete="off">
		</div>
        <?php if(isset($meta['business_registration']) && !empty($meta['business_registration'])): ?>
            <div class="form-group">
                <label>Business Registration / Trade License</label><br>
                <a href="/uploads/<?php echo $meta['business_registration']; ?>" target="_blank" class="btn btn-sm btn-info">View Document</a>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="is_gst_verified_staff" name="is_gst_verified_staff" value="1" <?php echo (isset($meta['is_gst_verified_staff']) && $meta['is_gst_verified_staff']) ? 'checked' : ''; ?>>
                <label class="custom-control-label" for="is_gst_verified_staff">Mark GST as Visually Verified (Staff Level)</label>
            </div>
            <?php if(isset($meta['is_gst_verified_admin']) && $meta['is_gst_verified_admin']): ?>
                <small class="text-success"><i class='bx bx-check-circle'></i> Fully Verified by Admin</small>
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