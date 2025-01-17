!DOCTYPE html>
<html>
<link rel="stylesheet" type="text/css" href="styles.css">
<head>
    
	<title>Doctor Appointment Viewer</title>
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
        }
	</style>
<h1><center> Discount Clinic <center></h1>
</head>
<body>
	<nav>
		<ul>
			<li class ="active"><a href="doctorhomepage.php">Home</a></li>
			<li><a href="doctor_profile.php">Profile</a></li>
			<li><a href="doctorappointments.php">Appointments</a></li>
			<li><a href ="doctor_form.php">Doctor Form</a></li>
			<li><a href="logout.php">Logout</a></li>
		</ul>
	</nav>
</body>

<body>
	<h2>Scheduled Appointments</h2>
	<table>
		<thead>
			<tr>
				<th>Appointment ID</th>
			    <th>Patient Name</th>
			    <th>Date</th>
			    <th>Time</th>
			    <th>Office Location</t>
			</tr>
		</thead>
	<tbody>
		<?php
			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {
					echo "<tr>";
					echo "<td>" . $row['appointment_id'] . "</td>";
					echo "<td>" . $row['first_name'] . " " . $row['last_name'] ."</td>";
					echo "<td>" . $row['date'] . "</td>";
					echo "<td>" . $row['time'] . "</td>";
					echo "<td>" . $row['street_address'] . " " . $row['city'] . " " . $row['state'] . " " . $row['zip'] . "</td>";
					echo "</tr>";
				}
			} else {
				echo "<tr><td colspan='5'>No appointments found.</td></tr>";
			}
			$conn->close();
		?>
		</tbody>
	</table>
</body>
</html>

<?php 
session_start();

	include("dbh-inc.php");
	include("functions.php");

	$user_data = check_login($conn);

	$TEST = $user_data['username'];
	$query = "SELECT user_id FROM user WHERE username = '$TEST'";
	$result = mysqli_query($conn, $query);
	if($result && mysqli_num_rows($result) > 0) {
		$user_data = mysqli_fetch_assoc($result);
		$user_id = $user_data['user_id'];
	} 

	$query = "SELECT doctor_id FROM doctor WHERE user_id = '$user_id'";
	$result = mysqli_query($conn, $query);

	if($result && mysqli_num_rows($result) > 0) {
		$doctor_data = mysqli_fetch_assoc($result);
		$doctor_id = $doctor_data['doctor_id'];
	}
	
	$sql = "SELECT * FROM appointment WHERE doctor_id = '$doctor_id' AND deleted = FALSE";

	$sql = "SELECT * 
	FROM discount_clinic.appointment, discount_clinic.office, discount_clinic.address, discount_clinic.doctor
	WHERE doctor.doctor_id = '$doctor_id' AND office.address_id = address.address_id AND appointment.office_id = office.office_id AND appointment.doctor_id = doctor.doctor_id";
	$result = $conn->query($sql);


	echo $result->num_row;

?>