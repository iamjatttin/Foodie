<?php
    $conn=mysqli_connect("localhost","root","","foodie");
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

?>
<html>
    <head>
      <title>FOODIE</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
      <style type="text/css">
          body{
            padding: 0;
            margin: 0;
          }
      </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light" style="background-color: red;">
            <div class="container">
              <a class="navbar-brand" href="#" style="font-size:30px; color: white;">FOODIE</a>
                <form class="d-flex">
                  <input class="form-control me-2" type="search" placeholder="Search Food Item" aria-label="Search">
                  <button class="btn-dark" type="submit">GO</button>
                </form>
              </div>
          </nav>
          <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="row mt-5">
                        <?php 
                            $callingPost = mysqli_query($conn, "select * from foods ");
                            while($row = mysqli_fetch_array($callingPost)){
                        ?>
                        <div class="col-md-4" style="margin-top: 30px;">
                            <a href="foodie.php?id=<?= $row['id'];?>" style="text-decoration:none">
                                <div class="card" >
                                    <div class="card-body">
                                        <img src="<?= $row['img'];?>" alt="..." style="height:150px" class="rounded-float-left img-fluid" >
                                        <p style="text-decoration: none; color: black;"><strong><?= $row['fname'];?></strong></p>
                                        <p style="text-decoration: none; color: black;"><strong>Rs.<?= $row['price'];?></strong></p>
                                        <button class="btn-danger" type="submit">ADD</button>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php } ?>    
                    </div>
                </div>
                
                <div class="col-4">
                    <div class="row mt-5">
                    <table class="table" style="margin-top: 30px; margin-left: 10px; border: black solid 4px;">
                    <?php
if(isset($_POST['clear'])){
    $sql ="TRUNCATE TABLE orders";
    $result=mysqli_query($conn,$sql);
    // if($result){
    //     echo "<script>window.open('foodie.php','_self')</script>";
    // }
}
if(isset($_GET['minus']) && isset($_GET['m_id'])){
    $id=$_GET['m_id'];
    $sql ="update orders SET qty = qty-1 where o_id = $id";
    $result=mysqli_query($conn,$sql);
    $result=mysqli_query($conn,"DELETE FROM orders WHERE qty=0;");
}
if(isset($_GET['plus']) && isset($_GET['p_id'])){
    $id=$_GET['p_id'];
    $sql ="update orders SET qty = qty+1 where o_id = $id";
    $result=mysqli_query($conn,$sql);
    // if($result){
    //     echo "<script>window.open('foodie.php','_self')</script>";
    // }
}
?>
                        <thead>
                            <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Item</th>
                            <th scope="col m-2">Price</th>
                            <th scope="col m-2" class="m-2">Qty.</th>
                            <th scope="col">TOTAL</th>
                            </tr>
                        </thead>
                        <?php
                        if(isset($_GET['id'])){
                            $f_id=$_GET['id'];
                            $result=mysqli_num_rows(mysqli_query($conn,"select * from orders where p_id=$f_id"));

                            if($result==0){
                                $insertorder=mysqli_query($conn,"insert into orders values ('','$f_id','1')");
                            }
                            else{
                                $updateorder=mysqli_query($conn,"update orders set qty=qty+1 where p_id=$f_id");
                            }
                        }
                        
                           
                        ?>

                        <tbody>
                            <?php
                                
                                $callingorder = mysqli_query($conn, "select * from orders join foods on orders.p_id=foods.id ");
                                $counter = 0;
                                $total=0;
                                while($row = mysqli_fetch_array($callingorder)){
                                $total=$total+($row['qty']*$row['price']);

                            ?>
                            <tr>
                            <th scope="row"><?= ++$counter;?></th>
                            <td><?=$row['fname'] ;?></td>
                            <td><?=$row['price'] ;?></td>
                            <td> <a href="foodie.php?plus&p_id=<?= $row['o_id'];?>"class="btn btn-danger m-1"   name="plus"> + </a><?=$row['qty'] ;?><a href="foodie.php?minus&m_id=<?= $row['o_id'];?>" class="btn btn-danger m-1"    name="minus">-</a></td>
                            <td><?=$row['qty']*$row['price']; ;?></td>
                            </tr>
                            
                            <?php } ?>
                        </tbody>
                        </table>
                        <H2 style="color: red;">TOTAL=<?=$total ;?></H2>
                        <form action="foodie.php" method="post">
                            <button class="btn-success btn" type="submit" style="margin-top: 30px; height: 50px;">ORDER NOW</button>
                            <button class="btn-danger btn" type="submit"  style="margin-top: 30px; height: 50px;">Print</button>
                            <button class="btn-secondary btn" type="submit"  name="clear" style="margin-top: 30px; height: 50px;">CLEAR</button>
                        </form>
                    </div>
                    </div>
                                              
                                 
                            
         
    </body>
</html>
