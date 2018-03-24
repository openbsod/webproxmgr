<?php
require('includes/config2.php'); 
set_include_path('includes/');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }

//define page title
$title = 'Order VDS';

// define variables and initialize with empty values
$nameErr = $coresErr = $memoryErr = $sizeErr = $ide2Err = $vnc_tokenErr = $vnc_passwordErr = $scsi0Err = $ostypeErr = $bootdiskErr = $ide0Err = $net0Err = $geoErr = $vnc_portErr = $first_ipErr = $second_ipErr = $passwdErr = "";
$name = $cores = $memory = $size = $ide2 = $vnc_token = $vnc_password = $bootdisk = $ostype = $scsi0 = $ide0 = $net0 = $geo = $vnc_port = $first_ip = $second_ip = $passwd = "";

if (!empty($_SERVER['HTTP_CLIENT_IP'])){
  $ip=$_SERVER['HTTP_CLIENT_IP'];
}elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
}else{
  $ip=$_SERVER['REMOTE_ADDR'];
}
$ip = ip2long($ip);

?>

<!doctype html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <title>VDS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" media="screen" href="style/memberpage.css">
    <img src="img/header2.jpg" alt="VDS" style="max-width: 100%"/>

    <!--[if lt IE 9]>
      <script src="includes/html5shiv.min.js"></script>
      <script src="includes/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div class="columns-container">

<div class="side-nav">

<h3>VNC url</h3>
<h4>Welcome, ID <?php echo $_SESSION['username']; ?> </h4>
<hr>

<?php

echo "<table class=table-fluid height=20 border: 0px>";
echo "<tr height=50 bgcolor=#428bca border: 0px></tr>";
class TableRows extends RecursiveIteratorIterator {
    function __construct($it) {
        parent::__construct($it, self::LEAVES_ONLY);
    }

    function current() {
        return "<td>" . parent::current(). "</td>";
    }

    function beginChildren() {
        echo "<tr style=color:#777 border:0px>";
    }

    function endChildren() {
        echo "</tr>" . "\n";
    }
}

require('includes/config3.php');

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT vnc FROM orders WHERE clientid = '".$_SESSION['username'] ."'");
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
        echo $v;
    }
}

catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
echo "</table>";

?>

<p></p>
<hr>
<p><a href='logout.php'>Logout</a></p>

</div>

<div id="stats" class="left-column">
<p></p>

<script src="includes/tabs.js" type="text/javascript"></script>

<div class="tab">
  <button class="btn btn-primary tablinks" onclick="openStats(event, 'CPU')">CPU</button>
  <button class="btn btn-primary tablinks" onclick="openStats(event, 'MEMORY')">MEMORY</button>
  <button class="btn btn-primary tablinks" onclick="openStats(event, 'HDD')">HDD</button>
  <button class="btn btn-primary tablinks" onclick="openStats(event, 'NETWORK')">NETWORK</button>
</div>
<p></p>

<div id="CPU" class="tabcontent">
<img border="0" title="CPU Usage" alt="" src="includes/rrd_cpu.php" /><br>
<img border="0" title="Load Average" alt="" src="includes/rrd_loadavg.php" /><br>
<img border="0" title="CPU iowait" alt="" src="includes/rrd_iowait.php" /><br>
</div>

<div id="MEMORY" class="tabcontent">
<img border="0" title="Memory Usage" alt="" src="includes/rrd_memory.php" /><br>
</div>

<div id="HDD" class="tabcontent">
<img border="0" title="HDD used" alt="" src="includes/rrd_root_used.php" /><br>
</div>

<div id="NETWORK" class="tabcontent">
<img border="0" title="Network IN" alt="" src="includes/rrd_netin.php" /><br>
<img border="0" title="Network OUT" alt="" src="includes/rrd_netout.php" /><br>
</div>
</div>

<div class="right-column">
<h3>Create new VM</h3>

<script src="includes/checkForm.js" type="text/javascript"></script>

<form accept-charset="ISO-8859-1" action="includes/insert-order.php" method="post" onsubmit="return validate();">

        <input type="hidden" name="clientid" id="clientid" value="<?php echo $_SESSION['username']; ?>">
	<input type="hidden" name="ostype" id="ostype" value="<?php echo htmlspecialchars($ostype);?>">
	<input type="hidden" name="bootdisk" id="bootdisk" value="<?php echo htmlspecialchars($bootdisk);?>">
	<input type="hidden" name="ide0" id="ide0" value="ma-70:">
	<input type="hidden" name="net0" id="net0" value="<?php echo htmlspecialchars($net0);?>">
	<input type="hidden" name="geo" id="geo" value="<?php echo htmlspecialchars($geo);?>">
	<input type="hidden" name="vnc_port" id="vnc_port" value="<?php echo htmlspecialchars($vnc_port);?>">
	<input type="hidden" name="ip" id="ip" value="<?php echo htmlspecialchars($ip);?>">
	<input type="hidden" name="scsi0" id="scsi0" value="ma-70:">

    <div>
	<input type="text" pattern="[0-9a-zA-Z\-]{6,12}" name="name" id="name" class="form-control input-lg" placeholder="VDS Name" value="<?php echo htmlspecialchars($name);?>" tabindex="1">
    </div>
	<p></p>
    <div>
        <input type="text" pattern="\d+" name="size" id="size" class="form-control input-lg" placeholder="HDD size (GB)" value="<?php echo htmlspecialchars($size);?>" tabindex="2">
    </div>
	<p></p>
    <div>
	<input type="text" pattern="\d+" name="cores" id="cores" class="form-control input-lg" placeholder="Cores ( 1 - 8 )" value="<?php echo htmlspecialchars($cores);?>" tabindex="3">
    </div>
	<p></p>
    <div>
	<input type="text" pattern="\d+" name="memory" id="memory" class="form-control input-lg" placeholder="Memory (MB )" value="<?php echo htmlspecialchars($memory);?>" tabindex="4">
    </div>
	<p></p>
    <div>
        <input type="hidden" pattern="[a-zA-Z0-9]{6,12}" name="vnc_token" id="vnc_token" class="form-control input-lg" value="<?php echo (substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',15)),0,48)); ?>" tabindex="5">
    </div>
	<p></p>
    <div>
        <input type="text" pattern="[a-zA-Z0-9]{6,12}" name="vnc_password" id="vnc_password" class="form-control input-lg" placeholder="VNC password" value="<?php echo htmlspecialchars($vnc_password);?>" tabindex="6">
	<p></p>
	    <div>
        <input type="text" pattern="[0-9a-zA-Z\-]{6,12}" name="passwd" id="passwd" class="form-control input-lg" placeholder="VDS password" value="<?php echo htmlspecialchars($passwd);?>" tabindex="1">
    </div>
        <p></p>
    <div>
        <input type="text" required pattern="((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){4}$" name="first ip" id="first_ip" class="form-control input-lg" placeholder="First IP" value="<?php echo htmlspecialchars($first_ip);?>" tabindex="2">
    </div>
        <p></p>
    <div>
        <input type="text" required pattern="((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){4}$" name="second ip" id="second_ip" class="form-control input-lg" placeholder="Second IP" value="<?php echo htmlspecialchars($second_ip);?>" tabindex="3">
    </div>
        <p></p>
    </div>

    <label class="btn btn-primary">
        <input type="radio" name="ide2" value="debian-9.1.0-amd64-netinst-preseed.iso" checked> Debian 9.1.0<br>
    </label>
	<p></p>
    <label class="btn btn-primary">
	<input type="radio" name="ide2" value="ubuntu-16.4-amd64-minimal-preseed.iso"> Ubuntu 16.04<br>
    </label>
	<p></p>
    <label class="btn btn-primary">
	<input type="radio" name="ide2" value="CentOS-7-x86_64-Minimal-1611-ks.iso"> Centos 7.3<br>
    </label>
	<p></p>
    <label class="btn btn-primary">
	<input type="radio" name="ide2" value="win2012.iso"> Windows Server 2012 R2<br>
    </label>
	<p></p>
    <label class="btn btn-primary">
	<input type="radio" name="ide2" value="win2008.iso"> Windows Server 2008 R2<br>
    </label>
	<p></p>
	<div class="btn btn-primary"><input type="submit" name="Submit" value="ORDER" class="btn btn-primary btn-block btn-lg" tabindex="6"></div>

</form>

<p id="error_with" ></p>

<form accept-charset="ISO-8859-1" action="includes/order.php" method="post">
</form>

	  	</div>

</div>

<footer>
      <h3>&copy;2018 OPENBSOD</h3>
</footer>

</body>
</html>
