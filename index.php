<?php

session_start();
require_once "config/db.php";

if (isset($_GET['delete'])){
    $deleteid = $_GET['delete'];
    $deletesql = $conn->query("DELETE FROM member WHERE id = $deleteid");
    $deletesql->execute();

    if ($deletesql){
        echo "<script>alert('Delete Successfully');</script>";
        $_SESSION['success'] = "Delete Successfully";

        header("refresh:1; url=index.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="phanupon" content="width=device-width, initial-scale=1.0">
    <title>crud document member</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>
<body>
 <!-- modal Bootstrap-->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Member</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="insert.php" method="post" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="firstname" class="col-form-label">First Name:</label>
            <input type="text" required class="form-control" name="firstname">
          </div>

          <div class="mb-3">
            <label for="lastname" class="col-form-label">Last Name:</label>
            <input type="text" required class="form-control" name="lastname">
          </div>

          <div class="mb-3">
            <label for="position" class="col-form-label">Position:</label>
            <input type="text" required class="form-control" name="position">
          </div>

          <div class="mb-3">
            <label for="img" class="col-form-label">Image:</label>
            <input type="file" required class="form-control" id="imgInput" name="img">
            <img width="100%" id="previewImg" alt="">
          </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="submit" class="btn btn-success">Submit</button>
    </div>

        </form>
      </div>
      
    </div>
  </div>
</div>
<!-- container-->
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <h1>CRUD Bootstrap</h1>

        </div>
        <div class="col-md-6 d-flex justify-content-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal">Add member </button>

        </div>

    </div>
    <hr>
    <?php if (isset($_SESSION['success'])) {?>
        <div class="alert alert-success"> 
         <?php 
            echo $_SESSION['success']; 
            unset($_SESSION['success']);
         ?>
        </div>
    <?php }?>

    <?php if (isset($_SESSION['error'])) {?>
        <div class="alert alert-danger"> 
         <?php 
            echo $_SESSION['error']; 
            unset($_SESSION['error']);
         ?>
        </div>
    <?php }?>

    <!-- Member Data -->
    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">First Name</th>
      <th scope="col">Last Name</th>
      <th scope="col">Position</th> 
      <th scope="col">img</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
      <?php 
      $stmt = $conn->query("SELECT * FROM member");
      $stmt->execute();
      $member = $stmt->fetchALL();
      if(!$member){
        echo "<tr><td colspan='6' class='text-center'>No Member foound </td></tr>";
      }else{
          foreach($member as $mem) {

      ?>
    <tr>
      <th scope="row"><?= $mem['id']; ?></th>
      <td><?= $mem['firstname']; ?></td>
      <td><?= $mem['lastname']; ?></td>
      <td><?= $mem['position']; ?></td>
      <td width="250px"><img width="100%" src="uploads/<?= $mem['img']; ?>" class="rounded" alt="member picture"></td>
      <td>
          <a href="edit.php?id=<?= $mem['id']; ?>" class="btn btn-warning">Edit</a>
          <a onclick="return confirm('Are you sure?');" href="?delete=<?= $mem['id']; ?>" class="btn btn-danger" >Delete</a>
      </td>
    </tr>
    <?php }
     } ?>
    </tr>
  </tbody>
</table>

</div>    


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script>
    let imgInput = document.getElementById('imgInput');
    let previewImg = document.getElementById('previewImg');

    imgInput.onchange = evy => {
        const [file] = imgInput.files;
        if(file){
            previewImg.src = URL.createObjectURL(file);
        }
    }
</script>

</body>
</html>