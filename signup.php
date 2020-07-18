<?php
    session_start();
    include_once "includes/class-autoloader.inc.php";
    if (isset($_SESSION['komitexLogisticsEmail'])) {
        header("location: index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="rgb(7, 66, 124)">
    <title>Komitex Logistics</title>
    <link rel="stylesheet" href="CSS/main.css">
    <link rel="stylesheet" href="CSS/signup.css">
    <link rel="shortcut icon" type="image/png" href="icons/logistics/018-motorcycle.png">
    <script src="jquery/jquery-3.4.1.min.js"></script>
</head>
<body>
    <?php
        require "header.php";
    ?>
    <main>
        <div class="signup-container">
            <form action="includes/signup.inc.php" method="POST" id="signup-form">
                <h1>SIGNUP</h1>
                <label for="fullname">Fullname:</label> 
                <input type="text" id="fullname" name="fullname" placeholder="Fullname" title="Your Fullname e.g. Jane Doe" pattern="([^\s][a-zA-zÀ-ž\s]+)" required>
                <label for="username">Username:</label> 
                <input type="text" id="username" name="username" placeholder="username" title="username e.g. Janedoe123" pattern="([^\s][a-zA-z0-9À-ž\s]+)" required>
                <label for="email">Email address:</label> 
                <input type="email" id="email" name="email" placeholder="email" title="e.g. komitexlogistics@gmail.com" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                <label for="phone">Phone Number:</label> 
                <input type="tel" id="phone" name="phone" placeholder="phone-number" title="Your phone-number e.g. 08165266847 or +2348165266847" pattern="[0-9+]{11,}" required>
                <label for="password">Password:</label> 
                <input type="password" id="password" name="password" placeholder="password" required>
                <label for="Rpassword">Retype Password:</label> 
                <input type="password" id="Rpassword" name="Rpassword" placeholder="Retype password" required>

                <button type="submit" name="signup" id="signup">Signup</button>
            </form>
        </div>
    </main>
    <?php
        require "footer.php";
    ?>
    <script src="javascript/main.js"></script>
    <script src="javascript/signup.js"></script>
</body>
</html>