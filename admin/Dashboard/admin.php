<?php require_once("../../Includes/portal_header.php"); ?>
<?php require_once("../../Includes/portal_sidebar.php"); ?>

<div class="overview-boxes">
    <div class="box">
        <div class="right-side">
            <div class="box-topic">Total members</div>
            <?php
                $sql = "SELECT * FROM member WHERE organization_id = " . ACTIVE_ORG_ID;
                if ($result=mysqli_query($con,$sql)) {
                    $rowcount=mysqli_num_rows($result);
                }
            ?>  
            <div class="number"><?php echo $rowcount ?></div>
        </div>
        <i class='bx bxs-user icon member'></i>
    </div>
    <div class="box">
        <div class="right-side">
            <div class="box-topic">Total Staff</div>
            <?php
                $sql = "SELECT * FROM staff WHERE organization_id = " . ACTIVE_ORG_ID;
                if ($result=mysqli_query($con,$sql)) {
                    $rowcount=mysqli_num_rows($result);
                }
            ?>  
            <div class="number"><?php echo $rowcount ?></div>
        </div>
        <i class='bx bxs-user-circle icon staff'></i>
    </div>
    <div class="box">
        <div class="right-side">
            <div class="box-topic">Society fund</div>
            <?php
                $query="SELECT SUM(amount_payed) as `societyfund` FROM maintenance WHERE organization_id = " . ACTIVE_ORG_ID;
                $res=mysqli_query($con, $query);
                $data=mysqli_fetch_array($res);
            ?> 
            <div class="number">₹<?php echo $data['societyfund'] ?: 0 ?></div>
        </div>
        <i class='bx bx-money icon money'></i>
    </div>
    <div class="box">
        <div class="right-side">
            <div class="box-topic">Unpaid Maintenance</div>
            <?php
                $sql = "SELECT * FROM maintenance WHERE status=0 AND organization_id = " . ACTIVE_ORG_ID;
                if ($result=mysqli_query($con,$sql)) {
                    $rowcount=mysqli_num_rows($result);
                }
            ?> 
            <div class="number"><?php echo $rowcount ?></div>
        </div>
        <i class='bx bxs-file icon file'></i>
    </div>
    <div class="box">
        <div class="right-side">
            <div class="box-topic">Amenity Bookings</div>
            <div class="number">₹0.00</div>
            <div style="font-size: 12px; color: #888;">(Coming Soon)</div>
        </div>
        <i class='bx bx-calendar-event icon file' style="background: #e2e3ff; color: #4e73df;"></i>
    </div>
    <div class="box">
        <div class="right-side">
            <div class="box-topic">Vendor Listings</div>
            <div class="number">₹0.00</div>
            <div style="font-size: 12px; color: #888;">(Coming Soon)</div>
        </div>
        <i class='bx bx-store-alt icon file' style="background: #e0f8e9; color: #1cc88a;"></i>
    </div>
</div>

<div class="sales-boxes">
    <div class="registry box">
        <div class="box-title">Registry</div>
        <table class="table-striped table-bordered col-md-12">
            <thead>
                <tr>
                    <th>#</th>
                    <th>In Time</th>
                    <th>Visitor Name</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $registry = $con->query("SELECT * FROM registry WHERE organization_id = " . ACTIVE_ORG_ID . " ORDER BY visitor_name ASC");
                    $i = 1;
                    if($registry && $registry->num_rows > 0) {
                        while($row= $registry->fetch_assoc()):
                ?>
                <tr>
                    <td><?php echo $i++ ?></td>
                    <td><?php echo ucwords($row['created_at']) ?></td>
                    <td><?php echo htmlspecialchars($row['visitor_name']) ?></td>
                </tr>
                <?php 
                        endwhile; 
                    } else {
                        echo '<tr><td colspan="3">No registry entries found.</td></tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>

    <div class="members box">
        <div class="box-title">Members Directory</div>
        <table class="table-striped table-bordered col-md-12">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Email</th>
                    <th>Username</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $member = $con->query("SELECT * FROM member WHERE organization_id = " . ACTIVE_ORG_ID . " ORDER BY username ASC");
                    $i = 1;
                    if($member && $member->num_rows > 0) {
                        while($row= $member->fetch_assoc()):
                ?>
                <tr>
                    <td><?php echo $i++ ?></td>
                    <td><?php echo htmlspecialchars($row['email']) ?></td>
                    <td><?php echo htmlspecialchars($row['username']) ?></td>
                </tr>
                <?php 
                        endwhile;
                    }
                ?>
            </tbody>
        </table>
        <div style="margin-top: 15px;">
            <a href="../Members/index.php" class="btn-modern">See All</a>
        </div>
    </div>
</div>

<?php require_once("../../Includes/portal_footer.php"); ?>