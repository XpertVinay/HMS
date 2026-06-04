<?php 
  require_once("../../Includes/config.php"); 
  require_once("../../Includes/session.php"); 
  if ($logged==false) {
       header("Location:../../login.php");
  }
extract($_POST);
$date = $date.'-01';
$chk = $con->query("SELECT * from maintenance where member_id = $id and date_format(maintenance_date,'%Y-%m') = '".date("Y-m",strtotime($date))."'")->num_rows;
if($chk > 0 && !isset($bid)){
	echo "<div class='container-fluid'><center><h3><b>Member's Maintenance already exist for the selected Month.</b></h3></center></div>";
	exit;
}
$query = $con->query("SELECT * FROM member where id=".$id)->fetch_array();
foreach($query as $k => $v){
	$$k = $v;
}

$m_fee = 0;
$s_fund = 0;
$c_fee = 0;

if(isset($bid)){
    $mf = $con->query("SELECT * from maintenance_items where maintenance_id = '".$bid."' and type = 1 ");
    if($mf->num_rows > 0) $m_fee = $mf->fetch_array()['amount'];
    
    $sf = $con->query("SELECT * from maintenance_items where maintenance_id = '".$bid."' and type = 2 ");
    if($sf->num_rows > 0) $s_fund = $sf->fetch_array()['amount'];
    
    $cf = $con->query("SELECT * from maintenance_items where maintenance_id = '".$bid."' and type = 3 ");
    if($cf->num_rows > 0) $c_fee = $cf->fetch_array()['amount'];
}
?> 
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<input type="hidden" name="reading[1]" value="0"><input type="hidden" name="consumption[1]" value="0"><input type="hidden" name="rate[1]" value="1"><input type="hidden" name="previous_reading[1]" value="0"><input type="hidden" name="previous_consumption[1]" value="0"><input type="hidden" name="previous_amount[1]" value="0">
			<input type="hidden" name="reading[2]" value="0"><input type="hidden" name="consumption[2]" value="0"><input type="hidden" name="rate[2]" value="1"><input type="hidden" name="previous_reading[2]" value="0"><input type="hidden" name="previous_consumption[2]" value="0"><input type="hidden" name="previous_amount[2]" value="0">
			<input type="hidden" name="reading[3]" value="0"><input type="hidden" name="consumption[3]" value="0"><input type="hidden" name="rate[3]" value="1"><input type="hidden" name="previous_reading[3]" value="0"><input type="hidden" name="previous_consumption[3]" value="0"><input type="hidden" name="previous_amount[3]" value="0">
            <input type="hidden" name="o_amount" value="0">
			
            <div class="form-group">
				<label class="control-label">Maintenance Fee</label>
				<input type="number" value="<?php echo $m_fee ?>" class="form-control amount-input" name="amount[1]">
			</div>
			<div class="form-group">
				<label class="control-label">Sinking Fund</label>
				<input type="number" value="<?php echo $s_fund ?>" class="form-control amount-input" name="amount[2]">
			</div>
            <div class="form-group">
				<label class="control-label">Clubhouse Fee</label>
				<input type="number" value="<?php echo $c_fee ?>" class="form-control amount-input" name="amount[3]">
			</div>

            <hr>
            <h4>Total Amount Due: <span id="total_due_display">0.00</span></h4>
		</div>
	</div>
</div>

<script>
    function calc_total(){
		var m_amount = $('[name="amount[1]"]').val() || 0;
		var e_amount = $('[name="amount[2]"]').val() || 0;
		var w_amount = $('[name="amount[3]"]').val() || 0;
		var total = parseFloat(m_amount) + parseFloat(e_amount) + parseFloat(w_amount);
		$('[name="o_amount"]').val(total);
		$('#total_due_display').html(parseFloat(total).toLocaleString('en-US',{style:"decimal",minimumFractionDigits:2,maximumFractionDigits:2}));
	}
    $('.amount-input').on('keyup keydown keypress changed', function(){
        calc_total();
    });
	$(document).ready(function(){
		calc_total();
	});
</script>
