<?php
include 'config.php';
session_start();
$user_now=$_SESSION['user_id'];
$downloads=mysqli_query($conn,"select * from my_downloads where my_downloads.user_id='$user_now'");







$user_id = $_SESSION['user_id'];
$user_name =$_SESSION['user_name'];

if(!isset($user_id)){
   header('location:login.php');
}


if(isset($_GET['remove'])){
    $remove_id=$_GET['remove'];
    mysqli_query($conn, "DELETE FROM `My_Downloads` WHERE id='$remove_id'") or die('query failed');
    $message[]='Removed Successfully';
    header('location:my_downloads.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="css/hello.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./images/logo1.png" type="image/x-icon">
    <title>NotesHive|My Downloads</title>
    <style>
        .cart-btn1,.cart-btn2{
            
            display: inline-block;
   margin: auto;
   padding:0.8rem 1.2rem;
   cursor: pointer;
   color:white;
   font-size: 15px;
   border-radius: .5rem;
   text-transform: capitalize;
        }
        .cart-btn1{
            margin-left: 40%;
            background-color: #ffa41c;
            color: black;
        }
        .cart-btn2{
            background-color: rgb(0, 167, 245);
            color: black;
        }
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
    <div class="cart_form">
    <?php
    if(isset($message)){
      foreach($message as $message){
        echo '
        <div class="message" id="messages"><span>'.$message.'</span>
        </div>
        ';
      }
    }
    ?>
        <table style="width: 70%; text-align:center; align-items:center; margin:10px auto;" >
<thead >
    <tr >
    <th>SN</th>
    <th>FileName</th>
    <th>Time</th>
    </tr>
</thead>
<tbody>
    <?php foreach($downloads as $down=>$key){  ?>
    <tr>
        <td><?= $down+1 ?></td>
        <td><?= $key['title'] ?></td>
        <td><?= date("l,d F Y H : i",$key['d_date'] )?></td>
    </tr>
        <?php }?>
</tbody>
</table>
       
    </div>
    <?php include'index_footer.php'; ?>
    
    <script>
setTimeout(() => {
  const box = document.getElementById('messages');

  // 👇️ hides element (still takes up space on page)
  box.style.display = 'none';
}, 5000);
</script>

</body>

</html>