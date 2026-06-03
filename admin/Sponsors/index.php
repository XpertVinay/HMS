<?php 
require_once("../../Includes/portal_header.php");
require_once("../../Includes/portal_sidebar.php");

// Handle form submission
if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $logo_url = mysqli_real_escape_string($con, $_POST['logo_url']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $website_url = mysqli_real_escape_string($con, $_POST['website_url']);
    mysqli_query($con, "INSERT INTO sponsors (name, logo_url, description, website_url) VALUES ('$name', '$logo_url', '$description', '$website_url')");
    echo "<script>window.location.href='index.php';</script>";
}
?>

<div class="box-title" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>Sponsors Management</h2>
    <button onclick="document.getElementById('addSponsorModal').style.display='flex'" class="btn-modern">Add Sponsor</button>
</div>

<div class="sales-boxes">
    <div class="box" style="width: 100%;">
        <table class="table-striped table-bordered col-md-12">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Logo</th>
                    <th>Name</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sponsors = $con->query("SELECT * FROM sponsors ORDER BY name ASC");
                    $i = 1;
                    if($sponsors && $sponsors->num_rows > 0) {
                        while($row = $sponsors->fetch_assoc()):
                ?>
                <tr>
                    <td><?php echo $i++ ?></td>
                    <td><img src="<?php echo htmlspecialchars($row['logo_url']) ?>" style="height:40px; max-width:80px; object-fit:contain;"></td>
                    <td><?php echo htmlspecialchars($row['name']) ?></td>
                    <td><?php echo htmlspecialchars($row['description']) ?></td>
                </tr>
                <?php 
                        endwhile;
                    } else {
                        echo '<tr><td colspan="4">No sponsors found.</td></tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div id="addSponsorModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:#fff; padding:30px; border-radius:12px; width:100%; max-width:500px; position:relative; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);">
        <span onclick="document.getElementById('addSponsorModal').style.display='none'" style="position:absolute; top:15px; right:20px; font-size:24px; cursor:pointer; color: #9ca3af;">&times;</span>
        <h3 style="margin-bottom:20px;">Add New Sponsor</h3>
        <form method="post" action="index.php" style="display:flex; flex-direction:column; gap:15px;">
            <div>
                <label style="display:block; margin-bottom:5px; font-weight:500;">Name</label>
                <input type="text" name="name" required style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px; font-family: var(--font-family);">
            </div>
            <div>
                <label style="display:block; margin-bottom:5px; font-weight:500;">Logo Image URL</label>
                <input type="url" name="logo_url" required style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px; font-family: var(--font-family);">
            </div>
            <div>
                <label style="display:block; margin-bottom:5px; font-weight:500;">Website URL (Optional)</label>
                <input type="url" name="website_url" style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px; font-family: var(--font-family);">
            </div>
            <div>
                <label style="display:block; margin-bottom:5px; font-weight:500;">Description</label>
                <textarea name="description" rows="3" style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px; font-family: var(--font-family);"></textarea>
            </div>
            <button type="submit" name="submit" class="btn-modern" style="width:100%; font-size: 16px;">Save Sponsor</button>
        </form>
    </div>
</div>

<?php require_once("../../Includes/portal_footer.php"); ?>
