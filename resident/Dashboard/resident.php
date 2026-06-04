<?php 
require_once("../../Includes/portal_header.php");
require_once("../../Includes/portal_sidebar.php");
?>

<div class="box-title" style="margin-bottom: 20px;">
    <h2>Member Dashboard</h2>
</div>

<div class="overview-boxes">
    <div class="box">
        <div class="right-side">
            <div class="box-topic">Total members</div>
            <?php
                $sql = "SELECT * FROM member";
                $rowcount = 0;
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
                $rowcount = 0;
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
            <div class="box-topic">Unpaid Maintenance</div>
            <?php
                $sql = "SELECT * FROM maintenance where status=0";
                $rowcount = 0;
                if ($result=mysqli_query($con,$sql)) {
                    $rowcount=mysqli_num_rows($result);
                }
            ?> 
            <div class="number"><?php echo $rowcount ?></div>
        </div>
        <i class='bx bx-pie-chart-alt-2 icon pie'></i>
    </div>
    
    <div class="box">
        <div class="right-side">
            <div class="box-topic">Events</div>
            <?php
                $sql = "SELECT * FROM events";
                $rowcount = 0;
                if ($result=mysqli_query($con,$sql)) {
                    $rowcount=mysqli_num_rows($result);
                }
            ?> 
            <div class="number"><?php echo $rowcount ?></div>
        </div>
        <i class='bx bx-calendar-event icon evnt'></i>
    </div>
</div>

<?php require_once("../../Includes/portal_footer.php"); ?>