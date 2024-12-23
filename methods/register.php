<?php
    include("dbconnect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Playwrite+ES+Deco+Guides&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="../css/bootstrap5.min.css" rel="stylesheet">
    <style>
        body
        {
            font-family: "Noto Sans", serif;
            font-weight: 400;
            font-style: normal;
        }
    </style>
</head>
<body style="background-color: #4fc3f7;">
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="card p-4 shadow-lg" style="width: 100%; max-width: 400px;">
            <h4 class="text-center mb-4">Register</h4>
            <form method = "POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Enter your name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">E-Mail</label>
                    <input type="text" class="form-control" name="email" placeholder="Enter your E-Mail" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Register</button>
                <div class="text-center mt-3">
                    Already a member?&nbsp;&nbsp;&nbsp;<a href="../index.php" class="text-decoration-none">Login</a>
                </div>
            </form>
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST")
                {
                    $name = $_POST['name'];
                    $email = $_POST['email'];
                    $pass = $_POST['password'];

                    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
                    {
                        echo "<div class='text-center text-danger mt-3'>Invalid email format.</div>";
                    }
                    else
                    {
                        $hash = password_hash($pass, PASSWORD_DEFAULT);
                        $sql = "INSERT INTO user (email, password, name) VALUES ('$email', '$hash', '$name')";
                        if (mysqli_query($conn, $sql))
                        {
                            echo "<script>alert('Registered Successfully'); window.location.href='../index.php';</script>";
                            exit();
                        }
                        else
                        {
                            echo "<div class='text-center text-danger mt-3'>Error: " . mysqli_error($conn) . "</div>";
                        }
                    }
                    mysqli_close($conn);
                }
            ?>
        </div>
    </div>
</body>
</html>
