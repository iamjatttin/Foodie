<?php
    $conn=mysqli_connect("localhost","root","","foodie");
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
   

?>
 <?php 
                   $callingPost = mysqli_query($conn, "select * from foods ");
                   while($row = mysqli_fetch_array($callingPost)){
                ?>
                 <div class="col-3">
                        <div class="card">
                            <img src="<?= $row['img'];?>" alt="" class="card-img-top">
                            <div class="card-body">
                                <h3 class="h6"><?= $row['fname'];?></h3>
                                <p class="small">Rs.<?= $row['price'];?></p>

                            </div>
                        </div>
                    </div>
                    <?php } ?>



