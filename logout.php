<?php
	session_start();
	unset($_SESSION['idpegawai']);
	unset($_SESSION['password']); 
	unset($_SESSION['pegawai']); 


	session_destroy();
	echo "
		<html>
		<head>
		<title>Logout</title>
		</head>
		<body>
		<script>
		alert('Anda berhasil logout');
		window.location = 'index.php';
		</script>
		</body>
		</html>
	";
