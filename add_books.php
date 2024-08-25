<?php
include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if (isset($_POST['add_books'])) {
  
  
  $btitle =$_POST['btitle'];
  $category =$_POST['Category'];
  $desc =$_POST['bdesc'];
  $img = $_FILES["image"]["name"];
  $file_name=$_FILES['file_name']['name'];
  $img_temp_name = $_FILES["image"]["tmp_name"];
  move_uploaded_file($_FILES["image"]["tmp_name"],"uploads/".$img);
  move_uploaded_file($_FILES["file_name"]["tmp_name"],"uploads/".$file_name); // PDF MOVED TO UPLOADS FOLDER

  if (empty($btitle)) {
    $message[] = 'Please Enter book title';
  } elseif (empty($category)) {
    $message[] = 'Please Choose a category';
  } elseif (empty($desc)) {
    $message[] = 'Please Enter book descriptions';
  } elseif (empty($img)) {
    $message[] = 'Please Choose Image';
  } else {

    $add_book = mysqli_query($conn, "INSERT INTO notes_info( `title`, `category`, `description`, `image`,`file_name`) 
    VALUES('$btitle','$category','$desc','$img','$file_name')") or die('Query failed');

    if ($add_book) {

      move_uploaded_file($_FILES['image']['tmp_name'], "uploads/$img");
      move_uploaded_file($_FILES['file_name']['tmp_name'], "uploads/$file_name");
      $message[] = 'New Book Added Successfully';
    } else {
      $message = 'Book Not Added Successfully';
    }
  }
}

if(isset($_GET['delete'])){
  $delete_id = $_GET['delete'];
  mysqli_query($conn, "DELETE FROM `notes_info` WHERE bid = '$delete_id'") or die('query failed');
  header('location:add_books.php');
}


if(isset($_POST['update_product'])){
  //  print_r($_FILES);exit();
  $update_p_id = $_POST['update_p_id'];
  $update_category = $_POST['update_category'];
  $update_title = $_POST['update_title'];
  $update_description = $_POST['update_description'];
  

  mysqli_query($conn, "UPDATE `notes_info` SET title='$update_title', description ='$update_description', category='$update_category' WHERE bid = '$update_p_id'") or die('query failed');

  $update_image = $_FILES['update_image']['name'];
  $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
  $file_name_temp=$_FILES['file_name']['tmp_name'];
  $file_name=$_FILES['file_name']['name'];

  $update_image_size = $_FILES['update_image']['size'];
//   $update_folder = 'uploads/'.$update_image;
//   $update_old_image = $_POST['update_old_image'];

  if(!empty($update_image)){
   //   if($update_image_size > 2000){
   //      $message[] = 'image file size is too large';
   //   }else{
        mysqli_query($conn, "UPDATE `notes_info` SET image = '$update_image', file_name='$file_name' WHERE bid = '$update_p_id'") or die('query failed');
        move_uploaded_file($update_image_tmp_name, "uploads/".$update_image);
        move_uploaded_file($file_name_temp, "uploads/".$file_name);
        unlink('uploads/'.$update_old_image);
   //   }
  }

  header('location:./add_books.php');

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/register.css">
  <link rel="icon" href="./images/logo1.png" type="image/x-icon">
  <title>NotesHive | Add Books</title>
</head>

<body>
  <?php
  include './admin_header.php'
  ?>
  <?php
  if (isset($message)) {
    foreach ($message as $message) {
      echo '
        <div class="message" id="messages"><span>' . $message . '</span>
        </div>
        ';
    }
  }
  ?>
  
<a class="update_btn" style="position: fixed ; z-index:100;" href="total_books.php">See All Books</a>
<div class="container_box">
    <form action="" method="POST" enctype="multipart/form-data">
      <h3>Add Books To <a href="index1.php"><span>NotesHive</span></a></h3>
      <input type="text" name="btitle" placeholder="Enter Author name" class="text_field">
      <select name="Category" id="" required class="text_field">
            <option>Notes</option>
            <option>CheatSheet</option>
            <option>Books</option>
         </select>
      <textarea name="bdesc" placeholder="Enter book description" id="" class="text_field" cols="18" rows="5"></textarea>
      <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="text_field">
      <input type="file" name="file_name" accept="pdf/*" class="text_field">
      <input type="submit" value="Add Book" name="add_books" class="btn text_field">
    </form>
  </div>

  <section class="edit-product-form">

<?php
   if(isset($_GET['update'])){
      $update_id = $_GET['update'];
      $update_query = mysqli_query($conn, "SELECT * FROM `notes_info` WHERE bid = '$update_id'") or die('query failed');
      if(mysqli_num_rows($update_query) > 0){
         while($fetch_update = mysqli_fetch_assoc($update_query)){
            // print_r($fetch_update);exit();
?>
<form action="" method="post" enctype="multipart/form-data">
   <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['bid']; ?>">
   <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
   <img src="./added_books/<?php echo $fetch_update['image']; ?>" alt="">
   
   <input type="text" name="update_title" value="<?php echo $fetch_update['title']; ?>" class="box" required placeholder="Enter  Name">
   <select class="box" name="update_category" value="<?= $fetch_update['category']?>" required class="text_field">
         <!-- <option selected disabled ></option> -->
         <option value="Notes">Notes</option>
         <option value="CheatSheet">CheatSheet</option>
         <option value="Books">Books</option>
      </select>
   <input type="text" name="update_description" value="<?php echo $fetch_update['description']; ?>" class="box" required placeholder="enter product description">
   <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
   <input type="file" class="box" name="file_name" accept="pdf/*">
   <input type="submit" value="update" name="update_product" class="delete_btn" >
   <input type="reset" value="cancel" id="close-update" class="update_btn" >
</form>
<?php
      }
   }
   }else{
      echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
   }
?>

</section>
  <section class="show-products">

   <div class="box-container">

      <?php
         $select_book = mysqli_query($conn, "SELECT * FROM Notes_info ORDER BY date DESC LIMIT 2;") or die('query failed');
         if(mysqli_num_rows($select_book) > 0){
            while($fetch_book = mysqli_fetch_assoc($select_book)){
      ?>
      <div class="box">
         <img class="books_images"  src="uploads/<?php echo $fetch_book['image']; ?>" alt="">
         <div class="name"style="margin-bottom:17px">Aurthor: <?php echo $fetch_book['title']; ?></div>
         <a href="add_books.php?update=<?php echo $fetch_book['bid']; ?>" class="update_btn">update</a>
         <a href="add_books.php?delete=<?php echo $fetch_book['bid']; ?>" class="delete_btn" onclick="return confirm('delete this product?');">delete</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>
   </div>

</section>



<script src="./js/admin.js"></script>
<script>
setTimeout(() => {
  const box = document.getElementById('messages');

  // 👇️ hides element (still takes up space on page)
  box.style.display = 'none';
}, 8000);
</script>
</body>

</html>