<?php
    session_start();
    include("methods/dbconnect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Playwrite+ES+Deco+Guides&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="css/bootstrap5.min.css" rel="stylesheet">
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
            <h4 class="text-center mb-4">Login</h4>
            <form method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" placeholder="Enter your username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
                <div class="text-center mt-3">
                    Not a member?&nbsp;&nbsp;&nbsp;<a href="methods/register.php" class="text-decoration-none">Register</a>
                </div>
            </form>
            <?php
                if($_SERVER['REQUEST_METHOD'] === 'POST')
                {
                    $username = $_POST['username'];
                    $password = $_POST['password'];

                    $query = "SELECT * FROM user WHERE name = '$username'";
                    $result = mysqli_query($conn, $query);

                    if(mysqli_num_rows($result) > 0)
                    {
                        $user = mysqli_fetch_assoc($result);
                        if(password_verify($password, $user['password']))
                        {
                            $_SESSION['user_id'] = $user['user_id'];
                            $_SESSION['username'] = $user['name'];
                            header("Location: methods/note.php");
                            exit;
                        }
                        else
                        {
                            echo "<script>alert('Invalid Password. Please try again'); window.location.href='#';</script>";
                        }
                    }
                    else
                    {
                        echo "<script>alert('User not Found'); window.location.href='#';</script>";
                    }
                }
            ?>
        </div>
    </div>
</body>
</html>
