<?php 
require_once("../../Includes/portal_header.php");
require_once("../../Includes/portal_sidebar.php");

// Handle form submission
if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $amount = mysqli_real_escape_string($con, $_POST['amount']);
    $date = mysqli_real_escape_string($con, $_POST['donation_date']);
    mysqli_query($con, "INSERT INTO donors (name, amount, donation_date) VALUES ('$name', '$amount', '$date')");
    // Reload page to prevent form resubmission
    echo "<script>window.location.href='index.php';</script>";
}
?>

<div class="box-title" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>Donors Management</h2>
    <button onclick="document.getElementById('addDonorModal').style.display='flex'" class="btn-modern">Add Donor</button>
</div>

<div class="sales-boxes">
    <div class="box" style="width: 100%;">
        <table class="table-striped table-bordered col-md-12">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Amount (₹)</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $donors = $con->query("SELECT * FROM donors ORDER BY donation_date DESC");
                    $i = 1;
                    if($donors && $donors->num_rows > 0) {
                        while($row = $donors->fetch_assoc()):
                ?>
                <tr>
                    <td><?php echo $i++ ?></td>
                    <td><?php echo htmlspecialchars($row['name']) ?></td>
                    <td><?php echo number_format($row['amount'], 2) ?></td>
                    <td><?php echo date('M d, Y', strtotime($row['donation_date'])) ?></td>
                </tr>
                <?php 
                        endwhile;
                    } else {
                        echo '<tr><td colspan="4">No donors found.</td></tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div id="addDonorModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:#fff; padding:30px; border-radius:12px; width:100%; max-width:500px; position:relative; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);">
        <span onclick="document.getElementById('addDonorModal').style.display='none'" style="position:absolute; top:15px; right:20px; font-size:24px; cursor:pointer; color: #9ca3af;">&times;</span>
        <h3 style="margin-bottom:20px;">Add New Donor</h3>
        <form method="post" action="index.php" style="display:flex; flex-direction:column; gap:15px;">
            <div>
                <label style="display:block; margin-bottom:5px; font-weight:500;">Name</label>
                <input type="text" name="name" required style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px; font-family: var(--font-family);">
            </div>
            <div>
                <label style="display:block; margin-bottom:5px; font-weight:500;">Amount (₹)</label>
                <input type="number" step="0.01" name="amount" required style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px; font-family: var(--font-family);">
            </div>
            <div>
                <label style="display:block; margin-bottom:5px; font-weight:500;">Donation Date</label>
                <input type="date" name="donation_date" required style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px; font-family: var(--font-family);">
            </div>
            <button type="submit" name="submit" class="btn-modern" style="width:100%; font-size: 16px;">Save Donor</button>
        </form>
    </div>
</div>

<?php require_once("../../Includes/portal_footer.php"); ?>
