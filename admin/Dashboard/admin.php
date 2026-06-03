<?php require_once("../../Includes/portal_header.php"); ?>
<?php require_once("../../Includes/portal_sidebar.php"); ?>

<div class="overview-boxes">
    <div class="box">
        <div class="right-side">
            <div class="box-topic">Total members</div>
            <?php
                $sql = "SELECT * FROM member";
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
                $sql = "SELECT * FROM staff";
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
                $query="select SUM(amount_payed) as `societyfund` from billing";
                $res=mysqli_query($con, $query);
                $data=mysqli_fetch_array($res);
            ?> 
            <div class="number">₹<?php echo $data['societyfund'] ?: 0 ?></div>
        </div>
        <i class='bx bx-money icon money'></i>
    </div>
    <div class="box">
        <div class="right-side">
            <div class="box-topic">Unpaid Bills</div>
            <?php
                $sql = "SELECT * FROM billing where status=0";
                if ($result=mysqli_query($con,$sql)) {
                    $rowcount=mysqli_num_rows($result);
                }
            ?> 
            <div class="number"><?php echo $rowcount ?></div>
        </div>
        <i class='bx bxs-file icon file'></i>
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
                    <th>Person Name</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $registry = $con->query("SELECT * FROM registry order by person_name asc");
                    $i = 1;
                    if($registry && $registry->num_rows > 0) {
                        while($row= $registry->fetch_assoc()):
                ?>
                <tr>
                    <td><?php echo $i++ ?></td>
                    <td><?php echo ucwords($row['created_at']) ?></td>
                    <td><?php echo htmlspecialchars($row['person_name']) ?></td>
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
                    $member = $con->query("SELECT * FROM member order by username asc");
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