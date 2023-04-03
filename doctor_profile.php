<?php
	session_start();
	include("dbh-inc.php");
    include("functions.php");

    $user_data = check_login($conn);
    $user_id = $user_data['user_ID'];
    $username = $user_data['username'];


    $patient = "SELECT *
				FROM discount_clinic.doctor, discount_clinic.user
				WHERE doctor.user_id = user.user_id AND user.username = '$username'";
	 
   	

    $patient_result = mysqli_query($conn, $patient);

	if($patient_result && mysqli_num_rows($patient_result) > 0) {
		$user_data = mysqli_fetch_assoc($patient_result);
		$user_first_name = $user_data['first_name'];
		$user_middle_initial =  $user_data['middle_initial'];
		$user_last_name =  $user_data['last_name'];
		$gender = $user_data['gender'];
		$specialty = $user_data['specialty'];
		$phone_number = $user_data['phone_number'];
		$DOB = $user_data['DOB'];


	} 

	$sql = "SELECT * 
	FROM discount_clinic.doctor_office, discount_clinic.office, discount_clinic.address, discount_clinic.doctor
	WHERE doctor_office.OID = office.office_id AND office.address_id = address.address_id AND doctor.doctor_id = doctor_office.DID AND doctor.doctor_id = 3";
	$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="styles.css">
	<title>Doctor Profile</title>
	<header>
		<h1><center>Doctor Profile</center></h1>
		<nav>
			<ul>
				<li class ="active"><a href="doctorhomepage.php">Home</a></li>
				<li><a href="doctor_profile.php">Profile</a></li>
				<li><a href="doctorappointments.php">Appointments</a></li>
				<li><a href ="doctor_form.php">Doctor Form</a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</nav>
	</header>
	<style>
	table {
		border-collapse: collapse;
		width: 100%;
	}

	th, td {
		text-align: center;
		padding: 8px;
		border: 1px solid #ddd;
	}

	tr:nth-child(even) {
		background-color: #f2f2f2;
	}

	h1 {
		font-size: 50px;
		margin-bottom: 20px;
	}

	.container {
		margin: auto;
		max-width: 800px;
		padding: 20px;
	}
</style>
</head>
<body>
	<h2>Personal Information</h2>
	<?php 
		echo "Name: " . $user_first_name . " " . $user_middle_initial . " " . $user_last_name . "<br>";
		echo "Specialty: " . $specialty . "<br>";
		echo "Gender: " . $gender . "<br>";
		echo "Date of Birth: " . $DOB . "<br>";
		echo "Phone Number: " . $phone_number . "<br>";
	 ?>
	 <h2>Office Locations</h2>
	 <?php 
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				echo "<tr>";
				echo "<td>" . $row['street_address'] . " " . $row['city'] . " " . $row['state'] . " " . $row['zip'] . "</td>" . "<br>";
				echo "</tr>";
			}
		} else {
			echo "<tr><td colspan='5'>This doctor does not work at any offices.</td></tr>";
		}
	  ?>
</body>
</html>