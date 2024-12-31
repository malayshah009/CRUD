<?php

$insert = false;
$update = false;
$delete = false;
//INSERT INTO `notes` (`sno`, `title`, `description`) VALUES (NULL, 'malay', 'hello');

$servername = "localhost";
$username = "root";
$password = "";
$database = "note";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Can't connect....." . mysqli_connect_error());
} else {
    //echo "Connected.....";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['snoEdit'])) {
        $title = $_POST['titleEdit'];
        $description = $_POST['descriptionEdit'];
        $sno = $_POST['snoEdit'];

        $sql = "UPDATE notes SET title = '$title',description = '$description'  WHERE sno = '$sno'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $update = true;
        }
    } else {
        $title = $_POST['title'];
        $description = $_POST['description'];

        $sql = "INSERT INTO notes(title, description) VALUES ('$title', '$description');";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $insert = true;
        }
    }
}

if (isset($_GET['delete'])) {
    $sno = $_GET['delete'];
    // echo $sno;

    $sql = "DELETE FROM notes WHERE sno = $sno;";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $delete = true;
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    <script src="//cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            let table = new DataTable('#myTable');
        })
    </script>
    <style>
        .back {
            width: auto;
            height: auto;
            background-color: black;
            color: white;
        }
    </style>

    <title>Hello, world!</title>
</head>

<body>
    <!-- <h1>Hello, world!</h1> -->

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/CRUD/index.php">CRUD</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item active">
                        <a class="nav-link" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#">Contact US</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                    <button class="btn btn-outline-success" type="submit">
                        Search
                    </button>
                </form>
            </div>
        </div>
    </nav>
    <div class="back ">
        <div class="container">
            <br>
            <br>
            <br>
            <h1>Hello, Netizen...</h1>
            <br>
            <br>
            <br>
        </div>
    </div>
    <?php
    if ($insert) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>SUCCESS!</strong> YOUR RECORD INSERTED SUCCESSFULLY......
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
    }
    ?>
    <?php
    if ($update) {
        echo "<div class='alert alert-primary alert-dismissible fade show' role='alert'>
        <strong>SUCCESS!</strong> YOUR RECORD UPDATED SUCCESSFULLY......
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
    }
    ?>
    <?php
    if ($delete) {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>SUCCESS!</strong> YOUR RECORD DELETED SUCCESSFULLY......
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
    }
    ?>
    <div class="container my-4">
        <form action="/CRUD/index.php" method="POST">
            <h2>Add Note</h2>
            <div class="mb-3">
                <label for="note" class="form-label">Note Title</label>
                <input type="text" name="title" class="form-control" id="note" aria-describedby="emailHelp" />
            </div>
            <div class="mb-3">
                <label for="note" class="form-label">Note Description</label>
                <textarea class="form-control" placeholder="Leave a Note here" id="description" name="description"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Note</button>
        </form>
    </div>


    <div class="container my-4">
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">sno</th>
                    <th scope="col">Note Title</th>
                    <th scope="col">Note Description</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM notes";
                $result = mysqli_query($conn, $sql);
                $sno = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $sno = $sno + 1;
                    echo "<tr>
          <th scope='row'>$sno</th>
          <td>$row[title]</td>
          <td>$row[description]</td>
          <td><button class='edit btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#editModal' id = " . $row['sno'] . " >Edit</button>  <button class='delete btn btn-sm btn-danger' id = d" . $row['sno'] . ">Delete</button> </td> 
          </tr>";
                }
                ?>

            </tbody>
        </table>
    </div>
    <hr>
</body>


<script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
        element.addEventListener("click", (e) => {
            console.log("edit", );
            tr = e.target.parentNode.parentNode;
            title = tr.getElementsByTagName("td")[0].innerText;
            description = tr.getElementsByTagName("td")[1].innerText;
            console.log(title, description);
            titleEdit.value = title;
            descriptionEdit.value = description;
            // sno = tr.getElementsByTagName("td")[0].innerText;
            snoEdit.value = e.target.id;
            console.log(e.target.id);
        })
    })
    //{ 1 , 'malay', 'shah'}
    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
        element.addEventListener("click", (e) => {
            console.log("delete", );
            sno = e.target.id.substr(1, )
            if (confirm("Press a button!")) {
                console.log("yes");
                window.location = `/CRUD/index.php?delete=${sno}`;
            } else {
                console.log("no")
            }
        })
    })
</script>
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel">Edit title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/CRUD/index.php" method="POST">
                    <h2>Edit Note</h2>
                    <input type="hidden" name="snoEdit" id="snoEdit">
                    <div class="mb-3">
                        <label for="note" class="form-label">Note Title</label>
                        <input type="text" name="titleEdit" class="form-control" id="titleEdit" aria-describedby="emailHelp" required />
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label">Note Description</label>
                        <textarea class="form-control" placeholder="Leave a Note here" id="descriptionEdit" name="descriptionEdit" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Note</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

</html>