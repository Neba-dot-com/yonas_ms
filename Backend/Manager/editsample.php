<?php
include "../../connection.php";
if (!isset($_SESSION['manager_user'])) {
        
    header("location:managerlog.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Check if a new image file was uploaded
    if (isset($_FILES['image1']) && $_FILES['image1']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image1']['name'];
        // Move the uploaded file to the target directory
        move_uploaded_file($_FILES["image1"]["tmp_name"], "../../images/" . $_FILES["image1"]["name"]);
    } else {
        // No new file was uploaded, so keep the existing image
        $image = $_POST['existing_image']; // Use the existing image name from the hidden input field
    }

    // Construct the SQL query
    $sql = "UPDATE mgsample SET Title='$title', img='$image', description='$description' WHERE id=$id";

    // Execute the SQL query
    $result = mysqli_query($conn, $sql);

    if ($result === TRUE) {
        // Set a session variable to indicate success
        header("location: med.php");
    } else {
        $error_message = "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();


}
?>
 
 <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Link Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />

    <!-- Link Style CSS -->
    <link rel="stylesheet" href="style.css">

    <title>Edit MED</title>
       <style type="text/css">
        .new hover{
            background-color: none;
        }
    </style>
    
    <style>
:root{
    --green:#088178;
    --black:#444;
    --light-color:#777;
    --box-shadow:.5rem .5rem 0 rgba(22, 160, 133, .2);
    --text-shadow:.4rem .4rem 0 rgba(0, 0, 0, .2);
    --border:.1rem solid var(--green);
}
    form{
    flex:1 1 35rem;
    background: #fff;
    border:var(--border);
    box-shadow: var(--box-shadow);
    text-align: left;
    padding: 2rem;
    border-radius: .5rem;
}
form .box2{
    width: 40%;
    margin:.5rem 0;
    border-radius: .6rem;
    border:var(--border);
    font-size: 0.8rem;
    color: var(--black);
    text-transform: none;
    padding: 1rem;

}
.image-container {
    position: relative;
    display: flex;
    align-items: center;
    height: 350px; /* Set a fixed height for the image container */
    overflow: hidden; /* Hide any overflow if the image is larger than the container */
}

.image-container img {
    max-height: 350px; /* Adjust this value to increase the image size */
    margin-right: 10px;
}

.image-container input[type="file"] {
    position: relative;
    width: auto;
    pointer-events: auto;
    margin-left: 5px;
    opacity: 0;
    cursor: pointer;
}

  </style>

</head>
<body>

    <!--  -->
    <div class="container">

        <!-- TopBar/Navbar -->
        <div class="TopBar">
            <div class="logo">
                <h1>Yonas <span style="color: white;"><b>M S</b> </span></h1>
            </div>

            <div class="Search">
                <input type="text" placeholder="Search Here" name="search">
                <label for="search"><i class="fas fa-search"></i></label>
            </div>

            <i class="fas fa-bell"></i>

        <div class="user">
              <a href="managerlog.html">   <img src="manager.png" alt=""> </a>
           <a href="expired.html"> <div id="notificationButton">
                <button id="notificationIcon"><i class="fas fa-bell fa-2x"></i></button> <a>
                <span id="notificationCount">0</span>
            </div>
        </div>
            



        </div>
        <!-- SideBar -->
<?php include "sidebar.php"?>
 <div class="MainChartM">

                <div class="ChartM">
 
                    <h1>EDIT MED</h1>  <br>
                    
                    <form method="POST" action="editsample.php" enctype="multipart/form-data"> <h1>EDIT CATEGORY</h1> <br>
                <?php
                $id = $_GET['id'];
                $sql = "SELECT * FROM mgsample where id='$id'";
                $res = $conn->query($sql);
                
                
                 
                    $result = mysqli_fetch_array($res) ;
                        $id = $result['id'];
                        $title = $result['Title'];
                        $description = $result['description'];
                        $image = $result['img'];
                        echo "
                        
                        <div class='form-group'>
                            <label>Title:&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</label>
                            <input type='text' name='title' value ='$title' class='box2'>
                        </div>
                        <div class='form-group'>
                            <label>Description:&nbsp &nbsp</label>
                            <textarea cols='16' name='description' rows='8' class='box2' required>$description</textarea>
                        </div>
                        <br>
                        <div class='form-group'>
                        <label>Image:&nbsp &nbsp</label>
                        <div class='image-container'>
                            <img id='previewImage' src='../../images/$image' alt=''>
                            <input type='file' id='image' name='image1' accept='image/*' style='border: none;' onchange='previewFile()'>
                            <input type='hidden' name='existing_image' value='$image'> <!-- Add this hidden input field -->
                        </div>
                    </div>
                    
                        <br>
                        <div>
                            &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
                            <i class='fas fa-save'></i>   <input type='submit' name='save' value='Save'>  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
                            <input type='reset' name='value='Reset'>
                        </div>
                        <input type='hidden' name='id' value ='$id' class='box2'>
                        ";
                    
        
                    
                
                ?>
                        <script>
    function previewFile() {
        const preview = document.getElementById('previewImage');
        const fileInput = document.getElementById('image');
        const file = fileInput.files[0];
        const reader = new FileReader();

        reader.addEventListener("load", function () {
            preview.src = reader.result;
        }, false);

        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>
                        </form>
                      </div>
                  </div>
</body>
</html>