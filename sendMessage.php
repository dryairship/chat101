<?php
	$conn = new mysqli('hostname', 'username', 'password', 'databasename');
	if($conn -> connect_error){
		die("Connection failed.");
	}

	$from = mysqli_real_escape_string($conn, $_GET['user']);
	$message = mysqli_real_escape_string($conn, $_GET['msg']);
	$to = mysqli_real_escape_string($conn, $_GET['to']);
	$sql0 = "select count from newmessages where `from`='".$from."' and `to`='".$to."';";
	$result0 = mysqli_query($conn,$sql0);
	if(mysqli_num_rows($result0)>0){
		$row0 = $result0->fetch_assoc();
		$count = intval($row0['count']);
		$sql1 = "insert into messages (`from`, `to`, `message`) values ('".$from."','".$to."','".$message."')";
		if($conn->query($sql1) === TRUE){
			$count++;
			$sql2 = "update newmessages set `count`='".$count."' where `from`='".$from."' and `to`='".$to."';";
			if($conn->query($sql2) === TRUE){
				echo 1;
			}else{
				echo 0;
			}
		}else{
			echo 0;
		}
	}else{
		$sql1 = "insert into messages (`from`, `to`, `message`) values ('".$from."','".$to."','".$message."')";
		if($conn->query($sql1) === TRUE){
			$sql2 = "insert into newmessages (`from`,`to`,`count`) values ('".$from."','".$to."','1');";
			if($conn->query($sql2) === TRUE){
				echo 1;
			}else{
				echo 0;
			}
		}else{
			echo 0;
		}

	}
	$conn->close();
?>
