<?php 
require_once("../../Includes/portal_header.php");
require_once("../../Includes/portal_sidebar.php");

// Handle form submission
if(isset($_POST['submit'])){
    $title = $_POST['title'];
    $image_url = $_POST['image_url'];
    $description = $_POST['description'];
    $stmt = $db->getPDO()->prepare("INSERT INTO gallery (title, image_url, description) VALUES (:title, :image, :desc)");
    $stmt->execute([':title' => $title, ':image' => $image_url, ':desc' => $description]);
    echo "<script>window.location.href='index.php';</script>";
}
?>

<div class="box-title" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>Gallery Management</h2>
    <button onclick="document.getElementById('addGalleryModal').style.display='flex'" class="btn-modern">Add Photo</button>
</div>

<div class="sales-boxes">
    <div class="box" style="width: 100%;">
        <table class="table-striped table-bordered col-md-12">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Date Uploaded</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $gallery = $con->query("SELECT * FROM gallery ORDER BY uploaded_at DESC");
                    $i = 1;
                    if($gallery && $gallery->num_rows > 0) {
                        while($row = $gallery->fetch_assoc()):
                ?>
                <tr>
                    <td><?php echo $i++ ?></td>
                    <td><img src="<?php echo htmlspecialchars($row['image_url']) ?>" style="height:60px; max-width:100px; object-fit:cover; border-radius:4px;"></td>
                    <td><?php echo htmlspecialchars($row['title']) ?></td>
                    <td><?php echo date('M d, Y', strtotime($row['uploaded_at'])) ?></td>
                </tr>
                <?php 
                        endwhile;
                    } else {
                        echo '<tr><td colspan="4">No photos found.</td></tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div id="addGalleryModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:#fff; padding:30px; border-radius:12px; width:100%; max-width:500px; position:relative; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);">
        <span onclick="document.getElementById('addGalleryModal').style.display='none'" style="position:absolute; top:15px; right:20px; font-size:24px; cursor:pointer; color: #9ca3af;">&times;</span>
        <h3 style="margin-bottom:20px;">Add New Photo</h3>
        <form method="post" action="index.php" style="display:flex; flex-direction:column; gap:15px;">
            <div>
                <label style="display:block; margin-bottom:5px; font-weight:500;">Title</label>
                <input type="text" name="title" required style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px; font-family: var(--font-family);">
            </div>
            <div>
                <label style="display:block; margin-bottom:5px; font-weight:500;">Image URL</label>
                <input type="url" name="image_url" required style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px; font-family: var(--font-family);">
            </div>
            <div>
                <label style="display:block; margin-bottom:5px; font-weight:500;">Description</label>
                <textarea name="description" rows="3" style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px; font-family: var(--font-family);"></textarea>
            </div>
            <button type="submit" name="submit" class="btn-modern" style="width:100%; font-size: 16px;">Save Photo</button>
        </form>
    </div>
</div>

<?php require_once("../../Includes/portal_footer.php"); ?>
