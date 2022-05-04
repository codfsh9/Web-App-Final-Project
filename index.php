<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Albums</title>
    <link rel="stylesheet" href="global.css" />
</head>
<body>
    <?php
    // Array of /album files albums/dog albums/cat etc
        $albums  = glob("albums/*" , GLOB_ONLYDIR);
        $albums  = glob("albums/*" , GLOB_ONLYDIR);
        $selected = $_GET["selected"];
        // Checking if selected is not null
        if(!isset($selected))
        {
            if(count($albums) == 0)
            {
                $selected = -1;
            }
            else
            {
                $selected = 0;
            }
        }
    ?>
    <div class="container">
        <header class="unit">
            <h1 class="unit"><?php echo (count($albums) == 0) ? "No Albums Found" : basename($albums[$selected]); ?></h1>
            <nav class="flex-list unit">
                <?php
                    if(count($albums) == 0)
                    {
                        echo "Place a folder containing images into the albums folder to create an album.";
                    }
                    else
                    {
                        for($i = 0; $i < count($albums); $i++)
                        {
                            echo "<a class='link' href='index.php?selected=".$i."'>".basename($albums[$i])."</a>";
                        }
                    }
                ?>
            </nav>
        </header>
        <main class="flex-list unit">
            <?php
                if(count($albums) == 0)
                {
                    echo "<em>Albums support pngs, jpgs, and gifs.</em>";
                }
                else
                {
                    $images = glob($albums[$selected]."/*.{jpg,png,gif}", GLOB_BRACE);
                    
                    if(count($images) == 0)
                    {
                        echo "<em>Please, add a photo</em>";
                    }
                    else
                    {
                        foreach($images as $image)
                        {
                            echo "<img class='photo' src='".$image."' width='200px' height='200px' />";
                        }
                    }
                }
            ?>
        </main>
        <footer class="unit">
            
            <form action = '' method = 'POST' enctype = 'multipart/form-data'>
            Choose a file to upload<input type='file' name = 'imgselect'> <br> <br>
            Choose a directoryyou wish to upload to:<select name="directory" id="d" size="1">
                <?php
                   foreach($albums as $album){
                ?>
                <option value="<?php echo basename($album,".jpeg")?>">
                            <?php echo basename($album,".jpeg");?>
                        </option>
                        <?php
                   }
                        ?>
                </select><br /><br>
            <input type= 'submit' name = 'submit'>
         

            <?php
          if(isset($_POST["submit"]))
          {
            $directory = $_POST['directory'];
            $image = $_FILES['imgselect'];
            move_uploaded_file($image['tmp_name'],"albums/$directory/".$image['name']);
            header("Refresh:0");
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
        
        for(var i = 0; i < photos.length; i++)
        {
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
