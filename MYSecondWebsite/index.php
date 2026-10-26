<?php 
// 1. Process Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['fullName'])) {$server = "localhost";
    $username = "root";
    $password = "";
    $database = "us_tour";

    $con = mysqli_connect($server,$username, $password,$database);

    if (!$con) {
        die("Connection to database failed due to: " . mysqli_connect_error());
    }

    // Collect input values matching your form attributes
    $fullName    =$_POST['fullName'];
    $studentId   =$_POST['rollNo'];     // Maps to 'studentId' column
    $collegeEmail =$_POST['email'];      // Maps to 'collegeEmail' column
    $phoneNo     =$_POST['phone'];      // Maps to 'phoneNo' column
    $destination =$_POST['destination'];

    // Insert into 'tourentries' table
    $sql = "INSERT INTO `tourentries` (`fullName`, `studentId`, `collegeEmail`, `phoneNo`, `destination`, `dt`) 
            VALUES ('$fullName', '$studentId', '$collegeEmail', '$phoneNo', '$destination', current_timestamp());";

    if ($con->query($sql) === TRUE) {$con->close();
        // Redirect to index.php with success flag to avoid resubmitting form on page refresh
        header("Location: index.php?success=1");
        exit();
    } else {
        echo "Error: $sql <br>" . $con->error;
        $con->close(); 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Trip Registration</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: url('college-front.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            background: rgb(255 255 255 / 85%);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 600px;
        }

        h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: center;
            font-size: 24px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #34495e;
            font-weight: 600;
            font-size: 14px;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            outline: none;
            transition: border-color 0.3s;
        }

        input:focus, select:focus {
            border-color: #3498db;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #3498db;
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
        }

        button:hover {
            background-color: #2980b9;
        }

        /* Styling for the Pink Success Message Banner */
        .submit-msg {
            color: #d81b60;
            background-color: #fce4ec;
            font-size: 1.25rem;
            font-weight: bold;
            padding: 14px 18px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid #f8bbd0;
        }
    </style>
</head>
<body>

<div class="container">

    <!-- 2. Display Success Banner above the form when success=1 is in URL -->
    <?php if (isset($_GET['success']) &&$_GET['success'] == 1): ?>
        <div class="submit-msg">
            Thanks for submitting your form. We are happy to have you join us for the trip!
        </div>
    <?php endif; ?>

    <!-- 3. Form submits POST to index.php -->
    <form id="tripForm" action="index.php" method="POST">
        <h2>College Trip Registration</h2>
        
        <div class="form-group">
            <label for="fullName">Full Name</label>
            <input type="text" id="fullName" name="fullName" required placeholder="John Doe">
        </div>

        <div class="form-group">
            <label for="rollNo">Roll Number / Student ID</label>
            <input type="text" id="rollNo" name="rollNo" required placeholder="CSC-204">
        </div>

        <div class="form-group">
            <label for="email">College Email</label>
            <input type="email" id="email" name="email" required placeholder="john@college.edu">
        </div>

        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" required placeholder="0300-1234567">
        </div>

        <div class="form-group">
            <label for="destination">Select Destination</label>
            <select id="destination" name="destination" required>
                <option value="" disabled selected>Choose a trip destination</option>
                <option value="Northern Areas (Mountains)">Northern Areas (Mountains)</option>
                <option value="Historical Sites Tour">Historical Sites Tour</option>
                <option value="Coastal / Beach Trip">Coastal / Beach Trip</option>
            </select>
        </div>

        <button type="submit" name="submit">Register Now</button>
    </form>
</div>

</body>
</html>