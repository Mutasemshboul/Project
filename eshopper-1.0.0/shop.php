<?php include 'header.php' ?>
<!-- Navbar End -->





<!-- Shop Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <!-- Shop Sidebar Start -->
        <div class="col-lg-3 col-md-12">
            <!-- Price Start -->



            <form action="shop.php" method="post">
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
<div class="container-fluid bg-secondary text-dark mt-5 pt-5">
    <div class="row px-xl-5 pt-5">
        <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
            <a href="" class="text-decoration-none">
                <h1 class="mb-4 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border border-white px-3 mr-1">E</span>Shopper</h1>
            </a>
            <p>Dolore erat dolor sit lorem vero amet. Sed sit lorem magna, ipsum no sit erat lorem et magna ipsum dolore amet erat.</p>
            <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>123 Street, New York, USA</p>
            <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>info@example.com</p>
            <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+012 345 67890</p>
        </div>
        <div class="col-lg-8 col-md-12">
            <div class="row">
                <div class="col-md-4 mb-5">
                    <h5 class="font-weight-bold text-dark mb-4">Quick Links</h5>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-dark mb-2" href="index.html"><i class="fa fa-angle-right mr-2"></i>Home</a>
                        <a class="text-dark mb-2" href="shop.html"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                        <a class="text-dark mb-2" href="detail.html"><i class="fa fa-angle-right mr-2"></i>Shop Detail</a>
                        <a class="text-dark mb-2" href="cart.html"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                        <a class="text-dark mb-2" href="checkout.html"><i class="fa fa-angle-right mr-2"></i>Checkout</a>
                        <a class="text-dark" href="contact.html"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                    </div>
                </div>
                <div class="col-md-4 mb-5">
                    <h5 class="font-weight-bold text-dark mb-4">Quick Links</h5>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-dark mb-2" href="index.html"><i class="fa fa-angle-right mr-2"></i>Home</a>
                        <a class="text-dark mb-2" href="shop.html"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                        <a class="text-dark mb-2" href="detail.html"><i class="fa fa-angle-right mr-2"></i>Shop Detail</a>
                        <a class="text-dark mb-2" href="cart.html"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                        <a class="text-dark mb-2" href="checkout.html"><i class="fa fa-angle-right mr-2"></i>Checkout</a>
                        <a class="text-dark" href="contact.html"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                    </div>
                </div>
                <div class="col-md-4 mb-5">
                    <h5 class="font-weight-bold text-dark mb-4">Newsletter</h5>
                    <form action="">
                        <div class="form-group">
                            <input type="text" class="form-control border-0 py-4" placeholder="Your Name" required="required" />
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control border-0 py-4" placeholder="Your Email" required="required" />
                        </div>
                        <div>
                            <button class="btn btn-primary btn-block border-0 py-3" type="submit">Subscribe Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row border-top border-light mx-xl-5 py-4">
        <div class="col-md-6 px-xl-0">
            <p class="mb-md-0 text-center text-md-left text-dark">
                &copy; <a class="text-dark font-weight-semi-bold" href="#">Your Site Name</a>. All Rights Reserved. Designed
                by
                <a class="text-dark font-weight-semi-bold" href="https://htmlcodex.com">HTML Codex</a><br>
                Distributed By <a href="https://themewagon.com" target="_blank">ThemeWagon</a>
            </p>
        </div>
        <div class="col-md-6 px-xl-0 text-center text-md-right">
            <img class="img-fluid" src="img/payments.png" alt="">
        </div>
    </div>
</div>
<!-- Footer End -->


<!-- Back to Top -->
<a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>

<!-- Contact Javascript File -->
<script src="mail/jqBootstrapValidation.min.js"></script>
<script src="mail/contact.js"></script>

<!-- Template Javascript -->
<script src="js/main.js"></script>
</body>

</html>