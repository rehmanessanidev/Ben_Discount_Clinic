<?php
ob_start();
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <script src="script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Patient Information Form</title>
    <style>
        label {
            display: block;
            margin-top: 10px;
        }

        input[type="text"],
        input[type="tel"],
        select {
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

    <h1>Patient Information Form</h1>
    <form method="post" action="">
        <label for="firstname">First Name:</label>
        <input type="text" id="first-name" name="firstname" required>

        <label for="middle-initial">Middle Initial:</label>
        <input type="text" id="middle-initial" name="middle-initial">

        <label for="last_name">Last Name:</label>
        <input type="text" id="last-name" name="last_name" required>



        <label for="gender">Gender:</label>
        <label for="gender-male"><input type="radio" id="gender-male" name="gender" value="M" required>Male</label>
        <label for="gender-female"><input type="radio" id="gender-female" name="gender" value="F" required>Female</label>
        <label for="gender-other"><input type="radio" id="gender-other" name="gender" value="O" required>Other</label>

        <label for="date-input">Date of Birth:</label>
        <input type="text" id="date-input" name="date-input" placeholder="MM/DD/YYYY" pattern="\d{2}/\d{2}/\d{4}" required>
        <p id="error-message"></p>


        <label for="phone">Phone number:</label>
        <input type="text" id="patientphone" name="phone" placeholder="123-456-7890" pattern="\d{3}-\d{3}-\d{4}" required>
        <span id="phone-error"></span>


        <h2>Patient Address</h2>
        <label for="street">Street:</label>
        <input type="text" id="street" name="street" required>

        <label for="city">City:</label>
        <input type="text" id="city" name="city" required>

        <label for="state">State:</label>
        <select id="state" name="state" required>
            <option value=""></option>
            <option value="AL">Alabama</option>
            <option value="AK">Alaska</option>
            <option value="AZ">Arizona</option>
            <option value="AR">Arkansas</option>
            <option value="CA">California</option>
            <option value="CO">Colorado</option>
            <option value="CT">Connecticut</option>
            <option value="DE">Delaware</option>
            <option value="DC">District Of Columbia</option>
            <option value="FL">Florida</option>
            <option value="GA">Georgia</option>
            <option value="HI">Hawaii</option>
            <option value="ID">Idaho</option>
            <option value="IL">Illinois</option>
            <option value="IN">Indiana</option>
            <option value="IA">Iowa</option>
            <option value="KS">Kansas</option>
            <option value="KY">Kentucky</option>
            <option value="LA">Louisiana</option>
            <option value="ME">Maine</option>
            <option value="MD">Maryland</option>
            <option value="MA">Massachusetts</option>
            <option value="MI">Michigan</option>
            <option value="MN">Minnesota</option>
            <option value="MS">Mississippi</option>
            <option value="MO">Missouri</option>
            <option value="MT">Montana</option>
            <option value="NE">Nebraska</option>
            <option value="NV">Nevada</option>
            <option value="NH">New Hampshire</option>
            <option value="NJ">New Jersey</option>
            <option value="NM">New Mexico</option>
            <option value="NY">New York</option>
            <option value="NC">North Carolina</option>
            <option value="ND">North Dakota</option>
            <option value="OH">Ohio</option>
            <option value="OK">Oklahoma</option>
            <option value="OR">Oregon</option>
            <option value="PA">Pennsylvania</option>
            <option value="RI">Rhode Island</option>
            <option value="SC">South Carolina</option>
            <option value="SD">South Dakota</option>
            <option value="TN">Tennessee</option>
            <option value="TX">Texas</option>
            <option value="UT">Utah</option>
            <option value="VT">Vermont</option>
            <option value="VA">Virginia</option>
            <option value="WA">Washington</option>
            <option value="WV">West Virginia</option>
            <option value="WI">Wisconsin</option>
            <option value="WY">Wyoming</option>
        </select>
        <label for="zipcode">Zip Code:</label>
        <input type="text" id="zipcode" name="zipcode" placeholder="12345" pattern="[0-9]{5}" required>

        <h1>Emergency Contact</h1>

        <label for="Emergencyfirst-name">First Name:</label>
        <input type="text" id="Emergencyfirst-name" name="Emergencyfirst-name" required>



        <label for="Emergencylast-name">Last Name:</label>
        <input type="text" id="Emergencylast-name" name="Emergencylast-name" required>

        <label for="Relationship">Relationship</label>
        <input type="text" id="Relationship" name="Relationship" required>

        <label for="emergencyContactPhone">Emergency Contact Phone Number:</label>
        <input type="text" id="emergencyContactPhone" name="emergencyContactPhone" pattern="\d{3}-\d{3}-\d{4}" placeholder="123-234-2334" required>
        <div id="emergencyContactPhoneError"></div>



        <h1>Medical Health Information</h1>
        <label for="allergies">Allergies:</label>
        <input type="text" id="allergies" name="allergies">
        <button type="submit" value="Submit">Submit</button>

        <form>
<?php


    include("dbh-inc.php");
    include("functions.php");

    $user_data = check_login($conn);
    $user_id_fk = $user_data['user_ID'];


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $firstname = $_POST['firstname'];
        $middleInitial = $_POST['middle-initial'];
        $last_name = $_POST['last_name'];
        $gender = $_POST['gender'];
        $dob = $_POST['date-input'];
        $dob = date('Y-m-d', strtotime($dob));
        $phone = $_POST['phone'];
        $street = $_POST['street'];
        $city = $_POST['city'];
        $state = $_POST['state'];

        $zip = $_POST['zipcode'];
        $emergencyFirstName = $_POST['Emergencyfirst-name'];
        $emergencyLastName = $_POST['Emergencylast-name'];
        $relationship = $_POST['Relationship'];
        $emergencyPhone = $_POST['emergencyContactPhone'];

        $allergies = $_POST['allergies'];

        $emergencyMiddleInitial =  ' ';



        $sql_address = "INSERT INTO address (street_address, city, state, zip, deleted) VALUES ('$street', '$city', '$state', '$zip', 0)";
        if (mysqli_query($conn, $sql_address)) {
            // Retrieve generated address_id value
            $address_id = mysqli_insert_id($conn);

            $sql_patient = "INSERT INTO patient (user_id, address_id, first_name, middle_initial, last_name, gender, phone_number, DOB, total_owe, deleted) 
            VALUES ($user_id_fk, $address_id, '$firstname', '$middleInitial', '$last_name', '$gender', '$phone', '$dob', 0, 0)";

            if (mysqli_query($conn, $sql_patient)) {
                // Retrieve generated patient_id value
                $patient_id = mysqli_insert_id($conn);

                // Insert new emergency contact record using the generated patient_id value
                $sql_emergency = "INSERT INTO emergency_contact (patient_id, e_first_name, e_middle_initial, e_last_name, phone_number, relationship, deleted) 
                VALUES ($patient_id, '$emergencyFirstName', '$emergencyMiddleInitial', '$emergencyLastName', '$emergencyPhone', '$relationship', 0)";

                if (mysqli_query($conn, $sql_emergency)) {
                    mysqli_close($conn);
                    header("Location: " . $_SERVER['PHP_SELF']);
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

    ?>
</body>
</html>
