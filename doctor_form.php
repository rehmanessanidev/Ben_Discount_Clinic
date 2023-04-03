<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <script src = "script.js" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<title>Doctor Information Form</title>
    <header>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <h1><center>Doctor Information Form</center></h1>
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
		label {
			display: block;
			margin-top: 10px;
		}
		input[type="text"], input[type="tel"], select {
			margin-top: 5px;
			padding: 5px;
			font-size: 16px;
			border-radius: 5px;
			border: none;
			border-bottom: 2px solid gray;
		}
		input[type="radio"] {
			margin-top: 5px;
			margin-right: 5px;
		}
		input[type="submit"] {
			margin-top: 20px;
			padding: 10px;
			font-size: 16px;
			color: white;
			border: none;
			border-radius: 5px;
			cursor: pointer;
		}
	</style>
</head>
<body>

	<form method="post" action = "<?php echo $_SERVER['PHP_SELF']; ?>" >
		<label for="firstname">First Name:</label>
		<input type="text" id="first-name" name="firstname" required>
		
		<label for="middle-initial">Middle Initial:</label>
		<input type="text" id="middle-initial" name="middle-initial">
		
		<label for="last_name">Last Name:</label>
		<input type="text" id="last-name" name="last_name" required>
	
		<label for="gender">Gender:</label>
        <label for= "gender-male"><input type="radio" id="gender-male" name="gender" value="M" required >Male</label>
        <label for= "gender-female"><input type="radio" id="gender-female" name="gender" value="F" required >Female</label>
        <label for= "gender-other"><input type="radio" id="gender-other" name="gender" value="O" required >Other</label>
		
        <label for="date-input">Date of Birth:</label>
        <input type="text" id="date-input" name="date-input" placeholder="MM/DD/YYYY"  pattern="\d{2}/\d{2}/\d{4}" required>
        <p id="error-message"></p>

        <label for="specialty">Specialty:</label>
        <input type ="text" id = "specialty" name="specialty" required>
        <button type="submit" value="Submit">Submit</button>
    
    <form >

    <?php
    session_start();

    include("dbh-inc.php");
    include("functions.php");

    $user_data = check_login($conn);
    $user_id_fk = $user_data['user_ID'];

    // Check if the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $firstname = $_POST['firstname'];
        $middleInitial = $_POST['middle-initial'];
        $last_name = $_POST['last_name'];
        $gender = $_POST['gender'];
        $dob = $_POST['date-input'];
        $dob = date('Y-m-d', strtotime($dob));
        $specialty = $_POST['speciality'];

    
        $sql_doctor = "INSERT INTO discount_clinic.doctor (doctor_id, user_id, first_name, middle_initial, last_name, phone_number, gender, DOB, specialty, deleted) VALUES 
        VALUES ($user_id_fk, $address_id, '$firstname', '$middleInitial', '$last_name', '$gender', '$phone', '$dob', 0, 0)";
        

        if(mysqli_query($conn, $sql_address)){
            $address_id = mysqli_insert_id($conn);
            $sql_patient = "INSERT INTO patien (user_id, address_id, first_name, middle_initial, last_name, gender, phone_number, DOB, total_owe, deleted) 
            VALUES ($user_id_fk, $address_id, '$firstname', '$middleInitial', '$last_name', '$gender', '$phone', '$dob', 0, 0)";
            
            if(mysqli_query($conn, $sql_patient)){
        
                $patient_id = mysqli_insert_id($conn);
                if(mysqli_query($conn, $sql_emergency)){
                    mysqli_close($conn);
                    header("Location: ".$_SERVER['PHP_SELF']);
                    header("Location: thankyouForm.php");
                } else {
                    echo "ERROR: Could not able to execute $sql_emergency. " . mysqli_error($conn);
                }
            } else {
                echo "ERROR: Could not able to execute $sql_patient. " . mysqli_error($conn);
            }
        } else {
            echo "ERROR: Could not able to execute $sql_address. " . mysqli_error($conn);
        }
    
        mysqli_close($conn);
    }
    ob_end_flush();
?>
</body>
</html>