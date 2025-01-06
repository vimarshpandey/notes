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
        $title = htmlspecialchars($_POST['noteTitle']);
        $body = htmlspecialchars($_POST['noteBody']);

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

    if(isset($_GET['delete']))
    {
        $note_id = $_GET['delete'];
        $query = "DELETE FROM notes WHERE note_id = '$note_id' AND user_id = '$user_id'";
        mysqli_query($conn, $query);
        header("Location: " .$_SERVER['PHP_SELF']);
        exit;
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit')
    {
        $note_id = $_POST['noteID'];
        $title = htmlspecialchars($_POST['noteTitle']);
        $body = htmlspecialchars($_POST['noteBody']);
        $query = "UPDATE notes SET title = '$title', note = '$body' WHERE note_id = '$note_id' AND user_id = '$user_id'";
        mysqli_query($conn, $query);
        header("Location: " .$_SERVER['PHP_SELF']);
        exit;
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
            <input type="hidden" name="action" value="add">
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
                        <h5 class="card-title"><?php echo htmlspecialchars($note['title']) ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($note['note']) ?></p>
                        <p class="text-muted small">Added on <?php echo htmlspecialchars($note['created_at']) ?></p>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-warning btn-sm" onclick="editNote('<?php echo $note['note_id']; ?>', '<?php echo htmlspecialchars($note['title']); ?>', '<?php echo htmlspecialchars($note['note']); ?>')">Edit</button>
                            <a href="?delete=<?php echo $note['note_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this note?');">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

     <!-- Edit Note Modal -->
     <div class="modal fade" id="editNoteModal" tabindex="-1" aria-labelledby="editNoteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" id="editNoteId" name="noteId">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editNoteModalLabel">Edit Note</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editNoteTitle" class="form-label">Title</label>
                            <input type="text" class="form-control" id="editNoteTitle" name="noteTitle" required>
                        </div>
                        <div class="mb-3">
                            <label for="editNoteBody" class="form-label">Body</label>
                            <textarea class="form-control" id="editNoteBody" name="noteBody" rows="5" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Open edit modal and populate fields
        function editNote(id, title, body)
        {
            document.getElementById('editNoteId').value = id;
            document.getElementById('editNoteTitle').value = title;
            document.getElementById('editNoteBody').value = body;
            new bootstrap.Modal(document.getElementById('editNoteModal')).show();
        }
    </script>

    <script src="../js/bootstrap.bundle.min.js"></script>

</body>
</html>