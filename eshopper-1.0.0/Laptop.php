<?php include 'header.php' ?>
<!-- Navbar End -->





<!-- Shop Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <!-- Shop Sidebar Start -->
        <div class="col-lg-3 col-md-12">
            <!-- Price Start -->



            <form action="Laptop.php" method="post">
                <select style="padding: 10px;  background:#edf2ff; border:none;" name="man">
                    <?php
                    include 'DBconn.php';
                    $S1 = "SELECT  DISTINCT(manufacturer) as manufacturer from Laptops2";
                    $ram = mysqli_query($connection, $S1);
                    while ($row = mysqli_fetch_array($ram)) {
                        echo '<option value="' . $row['manufacturer'] . '">' . $row['manufacturer'] . '</option>';
                    }



                    ?>
                </select>
                <select style="padding: 10px;  background:#edf2ff; border:none;" name="ram">
                    <?php
                    include 'DBconn.php';
                    $S1 = "SELECT  DISTINCT(RAM) as RAM from Laptops2";
                    $ram = mysqli_query($connection, $S1);
                    while ($row = mysqli_fetch_array($ram)) {
                        echo '<option value="' . $row['RAM'] . '">' . $row['RAM'] . '</option>';
                    }



                    ?>
                </select>

                <select style="padding: 10px;  background:#edf2ff; border:none;" name="cat">
                    <?php
                    include 'DBconn.php';
                    $S1 = "SELECT  DISTINCT(Category) as Category from Laptops2";
                    $ram = mysqli_query($connection, $S1);
                    while ($row = mysqli_fetch_array($ram)) {
                        echo '<option value="' . $row['Category'] . '">' . $row['Category'] . '</option>';
                    }



                    ?>
                </select>
                <select style="padding: 10px;  background:#edf2ff; border:none;" name="cpu">
                    <?php
                    include 'DBconn.php';
                    $S1 = "SELECT  DISTINCT(CPU) as CPU from Laptops2";
                    $ram = mysqli_query($connection, $S1);
                    while ($row = mysqli_fetch_array($ram)) {
                        echo '<option value="' . $row['CPU'] . '">' . $row['CPU'] . '</option>';
                    }



                    ?>
                </select>
                <!-- <select style="padding: 10px;  background:#edf2ff; border:none;" name="gpu">
  <?php
    include 'DBconn.php';
    $S1 = "SELECT  DISTINCT(GPU) as GPU from Laptops2";
    $ram = mysqli_query($connection, $S1);
    while ($row = mysqli_fetch_array($ram)) {
        echo '<option value="' . $row['GPU'] . '">' . $row['GPU'] . '</option>';
    }



    ?> -->
                </select>
                <select style="padding: 10px;  background:#edf2ff; border:none;" name="storage">
                    <?php
                    include 'DBconn.php';
                    $S1 = "SELECT  DISTINCT(Storage) as Storage from Laptops2";
                    $ram = mysqli_query($connection, $S1);
                    while ($row = mysqli_fetch_array($ram)) {
                        echo '<option value="' . $row['Storage'] . '">' . $row['Storage'] . '</option>';
                    }


                    ?>
                </select>
                <input type="text" required name="price">
                <input type="submit" name="sub">


            </form>










        </div>
        <!-- Shop Sidebar End -->


        <!-- Shop Product Start -->
        <div class="col-lg-9 col-md-12">
            <div class="row pb-3">
                <div class="col-12 pb-1">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <form action="">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search by name">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-transparent text-primary">
                                        <i class="fa fa-search"></i>
                                    </span>
                                </div>
                            </div>
                        </form>
                        <div class="dropdown ml-4">
                            <button class="btn border dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Sort by
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
                                <a class="dropdown-item" href="#">Latest</a>
                                <a class="dropdown-item" href="#">Popularity</a>
                                <a class="dropdown-item" href="#">Best Rating</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                include "DBconn.php";
                include "MyKNN.php";
                $sql = "select * from laptops2";
                $res = mysqli_query($connection, $sql);
                $sql2 = "select min(Price) as minprice from laptops";
                $resminprice = mysqli_query($connection, $sql2);
                $MinPrice = $row = mysqli_fetch_array($resminprice)["minprice"];
                //print_r($row=mysqli_fetch_array($res));


                while ($row = mysqli_fetch_array($res)) {
                    $sample[] = [$row['manufacturer'], $row['price'], $row['category'], $row["ram"], $row['cpu'], $row['storage'], $row['id']];
                }

                //print_r($sample[0][1]);
                if (isset($_POST['sub'])) {
                    $man = $_POST['man'];
                    $cat = $_POST['cat'];
                    $ram = $_POST['ram'];
                    $cpu = $_POST['cpu'];
                    $storage = $_POST['storage'];
                    $price = $_POST['price'];
                    $s = ForMin($sample, [$man, $price, $cat, $ram, $cpu, $storage], $MinPrice);
                } else {
                    $s = ForMin($sample, ["Lenovo", 1000, "Gaming", "16GB", "Intel Core i5", "512GB SSD"], $MinPrice);
                }
                //print_r($s);
                for ($i = 0; $i < 5; $i++) {
                    $a = $s[$i][1];
                    //print_r($s[$i]);
                    $sql = "select * from laptops2 where ID='$a'";
                    $res = mysqli_query($connection, $sql);
                    $row = mysqli_fetch_array($res);
                    echo ' <div class="col-lg-4 col-md-6 col-sm-12 pb-1">
                            <div class="card product-item border-0 mb-4">
                                <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                <img class="img-fluid w-100" src="img/product-2.jpg" alt="">
                                </div>
                                <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                    <h6 class="text-truncate mb-3">' . $row['manufacturer'] . '</h6>
                                    <div class="d-flex justify-content-center">
                                        <h6>' . $row['price'] . '</h6><h6 class="text-muted ml-2">$' . $row['ram'] . $row['category'] . '</h6>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-between bg-light border">
                                <form method="post" action="detail.php">
                        <button type="submit" class="btn btn-sm text-dark p-0" value="' . $row['id'] . '"  name="detail" style="background-color:white" ><i class="fas fa-eye text-primary mr-1"></i>View Detail</button>
                            <h5>&nbsp;</h5>
                            </form>
                            <form method="post" action="cartCode.php">
                            <button type="submit" class="btn btn-sm text-dark p-0" value="' . $row['id'] . '"  name="cart" style="background-color:white" ><i class="fas fa-shopping-cart text-primary mr-1"></i>Add Cart</button>
                                <h5>&nbsp;</h5>
                                </form>
                
                                    
                                </div>
                            </div>
                        </div>';
                }


                ?>

            </div>
        </div>
        <!-- Shop Product End -->
    </div>
</div>
<!-- Shop End -->


<!-- Footer Start -->
<?php include'footer1.php'?>