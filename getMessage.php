<?php
	$conn = new mysqli('hostname', 'username', 'password', 'databasename');
	if($conn -> connect_error){
		die("Connection failed.");
	}
	$from = mysqli_real_escape_string($conn, $_GET['from']);
	$to = mysqli_real_escape_string($conn, $_GET['to']);
	$sql0 = "select count from newmessages where `from`='".$from."' and `to`='".$to."';";
	$result0 = mysqli_query($conn,$sql0);
	$count = intval(($result0->fetch_assoc())['count']);
	if(mysqli_num_rows($result0)>0){
		while($count==0){
			$result0 = mysqli_query($conn,$sql0);
			$count = intval(($result0->fetch_assoc())['count']);
		}
		$sql1 = "select message from messages where `from`='".$from."' and `to`='".$to."' order by time desc limit ".$count.";";
		$result1 = mysqli_query($conn,$sql1);
		if(mysqli_num_rows($result1)>0){
			while($row1 = mysqli_fetch_array($result1)){
				echo $row1['message']."<br>";
			}
			$sql2 = "update newmessages set `count`='0' where `from`='".$from."' and `to`='".$to."';";
			$conn->query($sql2);
		}else{
			header("HTTP/1.0 500 Internal Server Error");
		}
	}else{
		header("HTTP/1.0 500 Internal Server Error");
    	die();
	}
	$conn->close();
?>
