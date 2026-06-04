<?php 
include('Includes/Database.php');
$db = Database::getInstance();
$con = $db->getConnection();
require_once("../../Includes/config.php");

if(isset($_GET['id'])){
    $qry = $con->query("SELECT * FROM property WHERE id = ".$_GET['id']);
    if($qry->num_rows > 0){
        $meta = $qry->fetch_array();
    }
}
$org_id = ACTIVE_ORG_ID;

// Fetch members for owner dropdown
$members = $con->query("SELECT id, name, username FROM member WHERE organization_id = $org_id ORDER BY name ASC");
$owner_options = "";
while($m = $members->fetch_assoc()) {
    $selected = (isset($meta['owner_id']) && $meta['owner_id'] == $m['id']) ? 'selected' : '';
    $owner_options .= "<option value='{$m['id']}' $selected>{$m['name']} ({$m['username']})</option>";
}

// Fetch residents for resident dropdown
$residents = $con->query("SELECT id, username FROM resident WHERE organization_id = $org_id ORDER BY username ASC");
$resident_options = "";
while($r = $residents->fetch_assoc()) {
    $selected = (isset($meta['resident_id']) && $meta['resident_id'] == $r['id']) ? 'selected' : '';
    $resident_options .= "<option value='{$r['id']}' $selected>{$r['username']}</option>";
}
?>
<div class="container-fluid">
    <div id="msg"></div>
    
    <form action="" id="manage-property">    
        <input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
        <div class="form-group">
            <label for="address">Address / Unit No.</label>
            <input type="text" name="address" id="address" class="form-control" value="<?php echo isset($meta['address']) ? htmlspecialchars($meta['address']): '' ?>" required>
        </div>
        <div class="form-group">
            <label for="type">Property Type</label>
            <select name="type" id="type" class="custom-select" required>
                <option value="Flat" <?php echo (isset($meta['type']) && $meta['type'] == 'Flat') ? 'selected' : '' ?>>Flat</option>
                <option value="Villa" <?php echo (isset($meta['type']) && $meta['type'] == 'Villa') ? 'selected' : '' ?>>Villa</option>
                <option value="Commercial" <?php echo (isset($meta['type']) && $meta['type'] == 'Commercial') ? 'selected' : '' ?>>Commercial</option>
                <option value="Other" <?php echo (isset($meta['type']) && $meta['type'] == 'Other') ? 'selected' : '' ?>>Other</option>
            </select>
        </div>
        <div class="form-group">
            <label for="owner_id">Owner</label>
            <select name="owner_id" id="owner_id" class="custom-select">
                <option value="">-- None --</option>
                <?php echo $owner_options; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="resident_id">Current Resident</label>
            <select name="resident_id" id="resident_id" class="custom-select">
                <option value="">-- None --</option>
                <?php echo $resident_options; ?>
            </select>
        </div>
    </form>
</div>
<script>
    $('#manage-property').submit(function(e){
        e.preventDefault();
        start_load()
        $.ajax({
            url:'ajax.php?action=save_property',
            method:'POST',
            data:$(this).serialize(),
            success:function(resp){
                if(resp ==1){
                    alert_toast("Data successfully saved",'success')
                    setTimeout(function(){
                        location.reload()
                    },1500)
                }else{
                    $('#msg').html('<div class="alert alert-danger">Error saving property</div>')
                    end_load()
                }
            }
        })
    })
</script>