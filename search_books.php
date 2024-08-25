<link rel="stylesheet" href="css/hello.css">
<?php
include 'config.php';
// print_r($_POST);exit(); 
// print_r(mysqli_fetch_assoc(mysqli_query($conn,"select * from users_info")));exit();

session_start();

if(isset($_SESSION['user_name'])){
   $user_id = $_SESSION['user_id'];
   
if (isset($_POST['add_to_cart'])) {
   $book_name = $_POST['book_name'];
   $book_id= $_POST['book_id'];
   $book_image = $_POST['book_image'];
   
   $select_book = $conn->query("SELECT * FROM My_Downloads WHERE bid= '$book_id' AND user_id='$user_id' ") or die('query failed');

   if (mysqli_num_rows($select_book) > 0) {
       $message[] = 'This Book is alredy in your Downloads';
   } else {
   $conn->query("INSERT INTO My_Downloads (`user_id`,`book_id`,`name`,`image`,) VALUES('$user_id','$book_id','$book_name','$book_image')") or die('Add to My Downloads Query failed');
   $message[] = 'Added To Successfully';
   header('location:index1.php');
   }
}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>NotesHive|search page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="icon" href="./images/logo1.png" type="image/x-icon">
   <style>
      .search-form form {
         max-width: 1200px;
         margin: 30px auto;
         display: flex;
         gap: 15px;
      }

      .search-form form .search_btn {
         margin-top: 0;
      }

      .search-form form .box {
         width: 100%;
         padding: 12px 14px;
         border: 2px solid rgb(0, 167, 245);
         font-size: 20px;
         color: black;
         border-radius: 5px;
      }

      .search_btn {
         display: inline-block;
         padding: 10px 25px;
         cursor: pointer;
         color: white;
         font-size: 18px;
         border-radius: 5px;
         text-transform: capitalize;
         background-color: rgb(0, 167, 245);
      }
   </style>
</head>

<body>

   <?php include 'index_header.php'; ?>

   <section class="search-form">

      <form action="" method="POST">
         <input type="text" class="box" name="search_box" placeholder="search products...">
         <input type="submit" name="search_btn" value="search" class="search_btn">
      </form>

   </section>

   <div class="msg">
      <?php
      if (isset($_POST['search_box'])) {
         $search_box = $_POST['search_box'];
         
         echo '<h4>Search Result for "'. $search_box.'"is:</h4>';
      };
      ?>
   </div>
   <section class="show-products">
      <div class="box-container">

         <?php
         if (isset($_POST['search_box'])) {
            // echo "<script>alert()</script>";
            extract($_POST);
            // $search_box = $_POST['search_box'];

            // $search_box = filter_var($search_box, FILTER_SANITIZE_STRING);
            $search_data=mysqli_query($conn, "SELECT * FROM Notes_info WHERE title LIKE '%$search_box%' OR category LIKE '%$search_box%'");
            // $select_products = mysqli_fetch_assoc($search_data);
            // print_r($select_products);exit();
            if (mysqli_num_rows($search_data) > 0) {
               while ($fetch_book = mysqli_fetch_assoc($search_data)) {
         ?>
            <div class="box">
         <img class="books_images" style="height: 200px;width: 125px;margin: auto;margin-bottom:10px"  src="uploads/<?php echo $fetch_book['image']; ?>" alt="">
         <div class="name">Name: <?= $fetch_book['title']; ?></div>
         
         <button type="button" style="margin-top:17px;margin-bottom:20px" name="add_to_cart"><a style="padding:10px; box-shadow:0px 0px 0px 5px;" class="update_btn" href="book_details.php?file_name=<?= $fetch_book['file_name'];?>">
                                    Download</a></button>
      </div>
         <?php
               }
            } else {
               echo '<p class="empty">Could not find "'. $search_box.'"! </p>';
            }
         };
         ?>
      </div>
   </section>




   <?php include 'index_footer.php'; ?>

   <script src="js/script.js"></script>

</body>

</html>