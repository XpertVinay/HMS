<?php
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) { die('Direct access not permitted.'); }
require_once(__DIR__ . "/../config.php");

$pdo = Database::getInstance()->getPDO();
$role = $_SESSION['account'];
$uid = null;
if ($role == 'super_admin' || $role == 'admin' || $role == 'staff') {
    $uid = $_SESSION['aid'];
} elseif ($role == 'member') {
    $uid = $_SESSION['uid'];
} elseif ($role == 'resident') {
    $uid = $_SESSION['rid'];
} elseif ($role == 'vendor') {
    $uid = $_SESSION['vid'];
}

$stmt = $pdo->prepare("SELECT * FROM $role WHERE id = :id");
$stmt->execute([':id' => $uid]);
$profile = $stmt->fetch();
?>
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card" style="border-radius:12px; border:none; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
            <div class="card-header bg-white" style="border-radius:12px 12px 0 0; border-bottom: 1px solid #eee;">
                <h4 class="mb-0">My Profile (<?php echo ucfirst($role); ?>)</h4>
            </div>
            <div class="card-body">
                <form id="profile-form" enctype="multipart/form-data">
                    <input type="hidden" name="role" value="<?php echo $role; ?>">
                    <input type="hidden" name="id" value="<?php echo $uid; ?>">

                    <?php if ($role == 'vendor'): ?>
                        <div class="form-group">
                            <label>Business Name</label>
                            <input type="text" class="form-control" name="business_name" value="<?php echo htmlspecialchars($profile['business_name']); ?>" required>
                        </div>
                    <?php else: ?>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($profile['username']); ?>" required>
                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($profile['email']); ?>" required>
                    </div>

                    <?php if ($role != 'super_admin'): ?>
                        <div class="form-group">
                            <label>Mobile Number</label>
                            <input type="text" class="form-control" name="mobile_number" value="<?php echo htmlspecialchars($profile['mobile_number'] ?? ($profile['phone'] ?? '')); ?>">
                        </div>
                    <?php endif; ?>

                    <?php if (in_array($role, ['member', 'resident'])): ?>
                        <div class="form-group">
                            <label>Address / Flat Number</label>
                            <input type="text" class="form-control" name="address" value="<?php echo htmlspecialchars($profile['address']); ?>">
                        </div>
                    <?php endif; ?>

                    <?php if ($role == 'admin'): ?>
                        <div class="form-group">
                            <label>Social Registration Number</label>
                            <input type="text" class="form-control" name="social_registration_number" value="<?php echo htmlspecialchars($profile['social_registration_number'] ?? ''); ?>">
                        </div>
                        <div class="form-group">
                            <label>RWA Election Result Copy (Upload)</label>
                            <input type="file" class="form-control-file" name="rwa_election_copy">
                            <?php if(!empty($profile['rwa_election_copy'])): ?>
                                <small><a href="/uploads/<?php echo $profile['rwa_election_copy']; ?>" target="_blank">View current document</a></small>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($role == 'member'): ?>
                        <div class="form-group">
                            <label>Share Certificate / Membership ID (Upload)</label>
                            <input type="file" class="form-control-file" name="share_certificate">
                            <?php if(!empty($profile['share_certificate'])): ?>
                                <small><a href="/uploads/<?php echo $profile['share_certificate']; ?>" target="_blank">View current document</a></small>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($role == 'resident'): ?>
                        <div class="form-group">
                            <label>Owner's NOC / Rent Agreement (Upload)</label>
                            <input type="file" class="form-control-file" name="owner_noc">
                            <?php if(!empty($profile['owner_noc'])): ?>
                                <small><a href="/uploads/<?php echo $profile['owner_noc']; ?>" target="_blank">View current document</a></small>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($role == 'staff'): ?>
                        <div class="form-group">
                            <label>Employment Contract / Agency Letter (Upload)</label>
                            <input type="file" class="form-control-file" name="employment_contract">
                            <?php if(!empty($profile['employment_contract'])): ?>
                                <small><a href="/uploads/<?php echo $profile['employment_contract']; ?>" target="_blank">View current document</a></small>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($role == 'vendor'): ?>
                        <div class="form-group">
                            <label>Business Registration / Trade License (Upload)</label>
                            <input type="file" class="form-control-file" name="business_registration">
                            <?php if(!empty($profile['business_registration'])): ?>
                                <small><a href="/uploads/<?php echo $profile['business_registration']; ?>" target="_blank">View current document</a></small>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label>Bank Account Details</label>
                            <textarea class="form-control" name="bank_account_details" rows="3"><?php echo htmlspecialchars($profile['bank_account_details']); ?></textarea>
                        </div>
                    <?php endif; ?>

                    <div class="form-group mt-4">
                        <label>New Password <small><i>(Leave blank if you don't want to change)</i></small></label>
                        <input type="password" class="form-control" name="password" autocomplete="new-password">
                    </div>

                    <button type="submit" class="btn btn-primary" style="background-color:#0d6efd; border-color:#0d6efd;">Save Profile</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true" style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
        <div class="toast-body text-white"></div>
    </div>

<script>
window.start_load = function() {
    if(!$('#preloader2').length) $('body').prepend('<div id="preloader2" style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(255,255,255,0.7);z-index:9999;display:flex;justify-content:center;align-items:center;">Loading...</div>');
}
window.end_load = function() {
    $('#preloader2').fadeOut('fast', function() { $(this).remove(); });
}
window.alert_toast = function($msg = 'TEST', $bg = 'success') {
    $('#alert_toast').removeClass('bg-success bg-danger bg-info bg-warning');
    if ($bg == 'success') $('#alert_toast').addClass('bg-success');
    if ($bg == 'danger') $('#alert_toast').addClass('bg-danger');
    if ($bg == 'info') $('#alert_toast').addClass('bg-info');
    if ($bg == 'warning') $('#alert_toast').addClass('bg-warning');
    $('#alert_toast .toast-body').html($msg);
    $('#alert_toast').toast({delay: 3000}).toast('show');
}

$('#profile-form').submit(function(e){
    e.preventDefault();
    start_load();
    var formData = new FormData($(this)[0]);
    $.ajax({
        url: '/Includes/Profile/ajax_profile.php',
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(resp){
            if(resp == 1){
                alert_toast("Profile successfully updated", 'success');
                setTimeout(function(){
                    location.reload();
                }, 1500);
            } else {
                alert_toast("Error updating profile", 'danger');
                end_load();
            }
        }
    });
});
</script>
