<?php
include 'config.php';
// if (!isset($_SESSION['user_name'])||!isset($_SESSION['admin_name'])) echo "<script>alert('Kindly logIn');location.href='login.php'</script>";
// error_reporting(0);
session_start();

//  $user_id = $_SESSION['user_id'];

if (isset($_POST['add_to_My_Downloads'])) {
    if (!isset($user_id)) {
        $message[] = 'Please Login to get your Notes';
    } else {
        $book_name = $_POST['book_name'];
        $book_id = $_POST['book_id'];
        $book_image = $_POST['book_image'];

        $book_quantity = '1';

        

        $select_book = $conn->query("SELECT * FROM my_downloads  WHERE book_id= '$book_id' AND user_id='$user_id' ") or die('query failed');

        if (mysqli_num_rows($select_book) > 0) {
            $message[] = 'This Book is alredy in your Downloads';
        } else {
            $conn->query("INSERT INTO My_Downloads (`user_id`,`book_id`,`title`, `image`,`total`) VALUES('$user_id','$book_id','$book_title','$book_image')") or die('Add to My_Downloads Query failed');
            $message[] = 'Book Added  Successfully';
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
    <link rel="stylesheet" href="css/hello.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet" />
    <link rel="icon" href="./images/logo1.png" type="image/x-icon">
    <title>NotesHive|Home</title>

    <style>
        img {
            border: none;
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
    <?php include 'index_header.php' ?>
    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '
        <div class="message" id= "messages"><span>' . $message . '</span>
        </div>
        ';
        }
    }
    ?>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>


    <section id="New">

        <div class="container px-5 mx-auto">
            <h2 class="m-8 font-extrabold text-4xl text-center border-t-2 " style="color: rgb(0, 167, 245);">
                New Arrived
            </h2>
        </div>
    </section>
    <section class="show-products">
        <div class="box-container">

            <?php
            $select_book = mysqli_query($conn, "SELECT * FROM `notes_info` ORDER BY date DESC LIMIT 8") or die('query failed');
            
            if (mysqli_num_rows($select_book) > 0) {
                while ($fetch_book = mysqli_fetch_assoc($select_book)) {
                    // print_r($fetch_book['image']);exit();
                    ?>

                    <div class="box" style="width: 255px; height:355px;">
                        <a href="book_details.php?details=<?php echo $fetch_book['bid'];
                        echo '-name=', $fetch_book['title']; ?>"> <img
                        style="height: 200px;width: 125px;margin: auto;" class="books_images"
                        src="uploads/<?php echo $fetch_book['image']; ?>" alt=""></a>
                        <div style="text-align:left ;">

                            <div style="font-weight: 500; font-size:18px; text-align: center; " class="name">
                                <?php echo $fetch_book['title']; ?>
                            </div>
                        </div>
                        
                        <form action="" method="POST">
                            <input class="hidden_input" type="hidden" name="book_name"
                                value="<?php echo $fetch_book['title'] ?>">
                            <input class="hidden_input" type="hidden" name="book_id" value="<?php echo $fetch_book['bid'] ?>">
                            <input class="hidden_input" type="hidden" name="book_image"
                                value="<?php echo $fetch_book['image'] ?>">
                                <button type="button" style="margin-top:17px" name="add_to_cart">
                                <a style="padding:10px; box-shadow:0px 0px 0px 5px;" class="update_btn" href="book_details.php?file_name=<?= $fetch_book['file_name'];?>">
                                    Download</a>
                            </button>
                        </form>
                    </div>
                    <?php
                }
            } else {
                echo '<p class="empty">Unavailable right Now!</p>';
            }
            ?>
        </div>
    </section>
    <section id="Notes">
        </div>

        <div class="container px-5 mx-auto">
            <h2 class="text-gray-400 m-8 font-extrabold text-4xl text-center border-t-2 text-red-800"
                style="color: rgb(0, 167, 245);">
                Notes
            </h2>
        </div>
    </section>
    <section class="show-products">
        <div class="box-container">

            <?php
            $select_book = mysqli_query($conn, "SELECT * FROM `notes_info` where category='Notes'") or die('query failed');
            if (mysqli_num_rows($select_book) > 0) {
                while ($fetch_book = mysqli_fetch_assoc($select_book)) {
                    ?>

                    <div class="box" style="width: 255px;height: 355px;">
                        <a href="book_details.php?details=<?php echo $fetch_book['bid'];
                        echo '-name=', $fetch_book['title']; ?>"> <img
                                style="height: 200px;width: 125px;margin: auto;" class="books_images"
                                src="uploads/<?php echo $fetch_book['image']; ?>" alt=""></a>
                        <div style="text-align:left ;">

                            <div style="font-weight: 500; font-size:18px; text-align: center; " class="name">
                                <?php echo $fetch_book['title']; ?>
                            </div>
                        </div>
                    
                        <form action="" method="POST">
                            <input class="hidden_input" type="hidden" name="book_name"
                                value="<?php echo $fetch_book['title'] ?>">
                            <input class="hidden_input" type="hidden" name="book_image"
                                value="<?php echo $fetch_book['image'] ?>">
                            
                                <button style="margin-top:17px" type="button" name="add_to_cart">
                                <a style="padding:10px; box-shadow:0px 0px 0px 5px;"class="update_btn" href="book_details.php?file_name=<?= $fetch_book['file_name'];?>">
                                    Download</a>
                            </button>
                        </form>
                        
                    </div>
                    <?php
                }
            } else {
                echo '<p class="empty">Unavailable right Now!</p>';
            }
            ?>
        </div>
    </section>
    <hr style="color: black; width:5px;">
    <section id="CheatSheet">

        <div class="container px-5 mx-auto">
            <h2 class="text-gray-400 m-8 font-extrabold text-4xl text-center border-t-2 text-red-800"
                style="color: rgb(0, 167, 245);">
                CheatSheet
            </h2>
        </div>
    </section>
    <section class="show-products">
        <div class="box-container">

            <?php
            $select_book = mysqli_query($conn, "SELECT * FROM `notes_info` where category='CheatSheet'") or die('query failed');
            if (mysqli_num_rows($select_book) > 0) {
                while ($fetch_book = mysqli_fetch_assoc($select_book)) {
                    ?>

                    <div class="box" style="width: 255px;height: 355px;">
                        <a href="book_details.php?details=<?php echo $fetch_book['bid'];
                        echo '-name=', $fetch_book['title']; ?>"> <img
                                style="height: 200px;width: 125px;margin: auto;" class="books_images"
                                src="uploads/<?php echo $fetch_book['image']; ?>" alt=""></a>
                        <div style="text-align:left ;">

                            <div style="font-weight: 500; font-size:18px; text-align: center;" class="name">
                                <?php echo $fetch_book['title']; ?>
                            </div>
                        </div>
                        
                                                <form action="" method="POST">
                            <input class="hidden_input" type="hidden" name="book_name"
                                value="<?php echo $fetch_book['title'] ?>">
                            <input class="hidden_input" type="hidden" name="book_image"
                                value="<?php echo $fetch_book['image'] ?>">
                            <button style="margin-top:17px"name="add_to_cart">
                                <a href="book_details.php?details=<?php echo $fetch_book['bid'];
                                echo '-name=', $fetch_book['title']; ?>"
                                    style="padding:10px; box-shadow:0px 0px 0px 5px;"class="update_btn">Downlod</a>
                        </form>
                        
                    </div>
                    <?php
                }
            } else {
                echo '<p class="empty">Unavailable right Now!</p>';
            }
            ?>
        </div>
    </section>
    <section id="Books">

        <div class="container px-5 mx-auto">
            <h2 class="text-gray-400 m-8 font-extrabold text-4xl text-center border-t-2 text-red-800"
                style="color: rgb(0, 167, 245);">
                Books
            </h2>
        </div>
    </section>
    <section class="show-products">
        <div class="box-container">

            <?php
            $select_book = mysqli_query($conn, "SELECT * FROM `notes_info` Where category='Books'") or die('query failed');
            if (mysqli_num_rows($select_book) > 0) {
                while ($fetch_book = mysqli_fetch_assoc($select_book)) {
                    // print_r($fetch_book);exit();
                    ?>

                    <div class="box" style="width: 255px;height: 355px;">
                    <a href="book_details.php?details=<?= $fetch_book['bid'];
                        echo $fetch_book['title']; ?>"> <img
                                style="height: 200px;width: 125px;margin: auto;" class="books_images"
                                src="uploads/<?php echo $fetch_book['image']; ?>" alt="">
                    </a>
                        <div style="text-align:left ;">

                            <div style="font-weight: 500; font-size:18px; text-align: center;" class="name">
                                <?php echo $fetch_book['title']; ?>
                            </div>
                        </div>
                        
                        
                        <form action="" method="POST">
                            <input class="hidden_input" type="hidden" name="book_name"
                                value="<?php echo $fetch_book['title'] ?>">
                            <input class="hidden_input" type="hidden" name="book_image"
                                value="<?php echo $fetch_book['image'] ?>">
                            
                            <button style="margin-top:17px" type="button" name="add_to_cart">
                                <a style="padding:10px; box-shadow:0px 0px 0px 5px;"class="update_btn" href="book_details.php?file_name=<?= $fetch_book['file_name'];?>">
                                    Download</a>
                            </button>
                        </form>
                       
                    </div>
                    <?php
                }
            } else {
                echo '<p class="empty">Unavailable right Now!</p>';
            }
            ?>
        </div>
    </section>
    <?php include 'index_footer.php'; ?>

    <script>
        setTimeout(() => {
            const box = document.getElementById('messages');

            // 👇️ hides element (still takes up space on page)
            box.style.display = 'none';
        }, 8000);
    </script>


</body>

</html>