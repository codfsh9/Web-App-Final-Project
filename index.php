<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Albums</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="global.css" />
</head>

<body>
    <?php
    // Array of /album files albums/dog albums/cat etc
    $albums  = glob("albums/*", GLOB_ONLYDIR);
    $albums  = glob("albums/*", GLOB_ONLYDIR);
    $selected = $_GET["selected"];
    // Checking if selected is not null
    if (!isset($selected)) {
        if (count($albums) == 0) {
            $selected = -1;
        } else {
            $selected = 0;
        }
    }
    ?>
    <!-- Class checks if there are no albums if not displays message if their are albums in the album directory
    it displays the album names 
          -->
    <div class="container">
        <header class="unit">
            <h1 class="unit"><?php echo (count($albums) == 0) ? "No Albums Found" : basename($albums[$selected]); ?></h1>
            <nav class="flex-list unit">
                <?php
                if (count($albums) == 0) {
                    echo "Place a folder containing images into the albums folder to create an album.";
                } else {
                    for ($i = 0; $i < count($albums); $i++) {
                        echo "<a class='link' href='index.php?selected=" . $i . "'>" . basename($albums[$i]) . "</a>";
                    }
                }
                ?>
            </nav>
        </header>
        <!-- Check to see if albums has any folders in the directory if so the $images array
            grabs all image files in each folder when it is selected and stores them then it checks if their are images
            in the folder and then displays the images with the required format
             -->
        <main class="flex-list unit">
            <?php

            if (count($albums) == 0) {
                echo "<em>Albums support pngs, jpgs, and gifs.</em>";
            } else {
                $images = glob($albums[$selected] . "/*.{jpg,png,gif}", GLOB_BRACE);

                if (count($images) == 0) {
                    echo "<em>Please, add a photo</em>";
                } else {
                    foreach ($images as $image) {
                        echo "<img class='photo' src='" . $image . "' width='200px' height='200px' />";
                    }
                }
            }
            ?>
        </main>
        <footer class="footerUnit">

            <form action='' method='POST' enctype='multipart/form-data'>
                <label> Choose a file to upload: </label>
                <input type='file' name='imgselect' id="inp"><br>
                <label>Choose a directory you wish to upload to: </label>
                <select name="directory" id="d" size="1">
                    <?php
                    foreach ($albums as $album) {
                    ?>
                        <option hidden selected>Select one...</option>
                        <option value="<?php echo basename($album, ".jpeg") ?>">
                            <?php echo basename($album, ".jpeg"); ?>
                        </option>
                    <?php
                    }
                    ?>
                </select>

                <input type='submit' name='submit' value="Upload" class="btn btn-primary">
                </br><br>
                <h4>OR</h4>
                </br>
                <form action='' method='POST' enctype='multipart/form-data'>
                    <label>Choose a file you wish to delete: </label>
                    <select name="imagedel" id="d" size="1">
                        <?php
                        foreach ($images as $image) {
                        ?>
                            <option hidden selected>Select one...</option>
                            <option value="<?php echo $image ?>">
                                <?php echo basename($image, ".jpeg"); ?>
                            </option>
                        <?php
                        }
                        ?>
                    </select>
                    <input type='submit' name='submit' value="Delete" class="btn btn-danger">

                    <?php
                    /*Checks if aything in submit if there is it grabs the data from the POST array and the 
                unlink method grabs the image and the image format and passes it through and deletes
                the specified file pased by the user
                        */
                    if (isset($_POST["submit"])) {
                        $imagedel = $_POST['imagedel'];
                        if (unlink($imagedel)) {
                            echo 'The file ' . $imagedel . ' was deleted successfully!';
                        } else {
                            echo 'There was a error deleting the file ' . $image;
                        }
                        header("Refresh:0");
                    }

                    if (isset($_POST["submit"])) {
                        $directory = $_POST['directory'];
                        $image = $_FILES['imgselect'];
                        move_uploaded_file($image['tmp_name'], "albums/$directory/" . $image['name']);
                    }

                    ?>
        </footer>
    </div>
    <div id="modal">
        <img id="modal-image" />
    </div>
    <script>
        var modal = document.getElementById("modal");
        var modalImage = document.getElementById("modal-image");
        var photos = document.getElementsByClassName("photo");

        for (var i = 0; i < photos.length; i++) {
            photos[i].onclick = function() {
                modal.style.display = "block";
                modalImage.src = this.src;
            }
        }

        modal.onclick = function() {
            modal.style.display = "none";
        };
    </script>
</body>

</html>