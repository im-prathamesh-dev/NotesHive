<?php
include 'config.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Kindly logIn');location.href='login.php'</script>";
    exit(); // Make sure to exit after redirecting
}

if(isset($_GET['file_name'])){
    $file_name = $_GET['file_name'];
    $file_path = "uploads/" . $file_name;
    
    if(file_exists($file_path)) {
        // Record the download in the database
        $time = time();
        $user_id = $_SESSION['user_id'];
        mysqli_query($conn, "INSERT INTO my_downloads(user_id, title, d_date) VALUES ('$user_id', '$file_name', '$time')") or die("Failed ");
        
        // Set headers for force download
        header("Content-Type: application/pdf");
        header("Content-Disposition: attachment;filename=" . $file_name);
        header("Content-Length: " . filesize($file_path));
        
        // Output the file content
        readfile($file_path);
        exit(); // Make sure to exit after sending the file
    } else {
        echo "File not found";
    }
}
exit();
// error_reporting(0);
// session_start();

$user_id = $_SESSION['user_id'];

if (isset($_POST['add_to_cart'])) {
    if(!isset($user_id)){
        $message[]= 'Please Login to get your books';
     }else{
    $book_name = $_POST['book_name'];
    $book_id = $_POST['book_id'];
    $book_image = $_POST['book_image'];
    $select_book = $conn->query("SELECT * FROM My_Downloads WHERE name= '$book_name' AND user_id='$user_id' ") or die('query failed');

    if (mysqli_num_rows($select_book) > 0) {
        $message[] = 'This Book is alredy in your Downlods';
    } else {
        $conn->query("INSERT INTO My_Downloads (`book_id`,`user_id`,`name`,  `image`, ) VALUES('$book_id','$user_id','$book_name','$book_image',)") or die('Add to Downloads Query failed');
        $message[] = 'Book Added To Downloads Successfully';
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
    <link rel="stylesheet" href="./css/index_book.css">
    <link rel="icon" href="./images/logo1.png" type="image/x-icon">
    <title>NotesHive|Selected items</title>

    <style>
        .message {
  position: sticky;
  top: 0;
  margin: 0 auto;
  width: 61%;
  background-color: #fff;
  padding: 6px 9px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  z-index: 100;
  gap: 0px;
  border: 2px solid rgb(68, 203, 236);
  border-top-right-radius: 8px;
  border-bottom-left-radius: 8px;
}
.message span {
  font-size: 22px;
  color: rgb(240, 18, 18);
  font-weight: 400;
}
.message i {
  cursor: pointer;
  color: rgb(3, 227, 235);
  font-size: 15px;
}
    </style>
</head>

<body>
    <?php
    include 'index_header.php';
    ?>
        <?php
    if(isset($message)){
      foreach($message as $message){
        echo '
        <div class="message" id= "messages"><span>'.$message.'</span>
        </div>
        ';
      }
    }
    ?>
    <div class="details">
        <?php
        if (isset($_GET['details'])) {
            $get_id = $_GET['details'];
            $get_book = mysqli_query($conn, "SELECT * FROM `Notes_info` WHERE bid = '$get_id'") or die('query failed');
            if (mysqli_num_rows($get_book) > 0) {
                while ($fetch_book = mysqli_fetch_assoc($get_book)) {
        ?>
                    <div class="row_box">
                        <form style="display: flex ;" action="" method="POST">
                            <div class="col_box">
                                <img src="./added_books/<?php echo $fetch_book['image']; ?>" alt="<?php echo $fetch_book['name']; ?>">
                            </div>
                            <div class="col_box">
                                <h4>Author: <?php echo $fetch_book['title']; ?></h4>
                                
                                <div class="buttons">


                                    <input class="hidden_input" type="hidden" name="book_name" value="<?php echo $fetch_book['name'] ?>">
                                    <input class="hidden_input" type="hidden" name="book_id" value="<?php echo $fetch_book['bid'] ?>">
                                    <input class="hidden_input" type="hidden" name="book_image" value="<?php echo $fetch_book['image'] ?>">
                                    <input type="submit" name="add_to_cart" value="Add To Cart" class="btn">
                                    <!-- <input type="submit" name="add_to_cart" value="Add to cart" class="btn"> -->
                                    <button name="Download" >Download</button>
                                </div>
                                <h3>Book Details</h3>
                                <p><?php echo $fetch_book['description']; ?></p>
                            </div>
                        </form>
                    </div>
        <?php
                }
            }
        } else {
            echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
        }
        ?>
    </div>
    <script src="./js/admin.js"></script>
    <script>
setTimeout(() => {
  const box = document.getElementById('messages');

  // 👇️ hides element (still takes up space on page)
  box.style.display = 'none';
}, 5000);
</script>
</body>

</html>