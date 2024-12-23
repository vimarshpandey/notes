<?php
    include("dbconnect.php");
    session_start();

    if(!isset($_SESSION['user_id']))
    {
        header("Location: ../index.php");
        exit;
    }

    $user_id = $_SESSION['user_id'];
    if($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $title = $_POST['noteTitle'];
        $body = $_POST['noteBody'];

        $query = "INSERT INTO notes (user_id, title, note) VALUES ('$user_id', '$title', '$body')";
        if(mysqli_query($conn, $query))
        {
            echo "<script>alert('Note added Successfully'); window.location.href='#';</script>";
        }
        else
        {
            echo "<script>alert('Some Error Occured'); window.location.href='#';</script>";
        }
    }

    $notes = [];
    $query = "SELECT * FROM notes WHERE user_id = '$user_id' ORDER BY created_at DESC";
    $result = mysqli_query($conn, $query);
    if($result)
    {
        $notes = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes</title>
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
<body class="container my-4" style="background-color: #4fc3f7;">
    <h1 class="text-center mb-4">Notes App</h1>

    <div class="form-container mb-4 d-flex justify-content-center align-items-center">
        <form id="noteForm" method="POST">
            <div class="col-md-12">
                <label for="noteTitle" class="form-label">Title:</label>
                <input type="text" id="noteTitle" name="noteTitle" class="form-control" required>
                <label for="noteBody" class="form-label">Body:</label>
                <textarea id="noteBody" name="noteBody" rows="5" class="form-control" required></textarea>
            </div>
            <div class="col-md-12 text-center mt-3">
                <button type="submit" class="btn btn-primary">Add Note</button>
            </div>
        </form>
    </div>

    <div class="notes-container">
        <h3 class="text-center">Your Notes</h3>
        <div class="row">
            <?php foreach($notes as $note): ?>
            <div class="col-md-3 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $note['title'] ?></h5>
                        <p class="card-text"><?php echo $note['note'] ?></p>
                        <p class="text-muted small">Added on <?php echo $note['created_at'] ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>
</html>