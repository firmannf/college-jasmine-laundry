<?php
	require "../../php/connection.php";
	$id = $_POST['id'];
	$login_id = $_POST['login_id'];
	$nama = $_POST['nama'];
	$username = $_POST['username'];
	$password = $_POST['password'];
			
	mysqli_begin_transaction($connection, MYSQLI_TRANS_START_READ_WRITE);
	mysqli_autocommit($connection, FALSE);

	$strQuery = "UPDATE agen SET agen_nama = '$nama' WHERE agen_id = $id";
	$query = mysqli_query($connection, $strQuery);
	if($query){		
		if(!empty($password)){
			$encPassword = md5($password);
			$strQuery = "UPDATE login SET login_username = '$username', login_password = '$encPassword' WHERE login_id = $login_id";
		}else {
			$strQuery = "UPDATE login SET login_username = '$username' WHERE login_id = $login_id";
		}		
		$query = mysqli_query($connection, $strQuery);
		if($query){
			mysqli_commit($connection);	
		}else {
			mysqli_rollback($connection);
			echo "<script language=javascript>alert('Terjadi Kesalahan Saat Mengupdate Data Login Agen');</script>";
		}
	}else{
		mysqli_rollback($connection);
		echo "<script language=javascript>alert('Terjadi Kesalahan Saat Mengupdate Data Agen');</script>";
	}
	
	mysqli_autocommit($connection, TRUE);
	echo "<script language=javascript>document.location.href='../agen.php'</script>";
	mysqli_close($connection);
?>