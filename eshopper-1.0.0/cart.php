<?php include 'header.php'?>
    <!-- Navbar End -->


    <!-- Page Header Start -->

    <!-- Page Header End -->


    <!-- Cart Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        <?php 
                        include 'DBconn.php';
                        //session_start();
                        $sql ='select * from shppoingcart where UserId  = '.$_SESSION['UserID'].'';
                        $res = mysqli_query($connection,$sql);
                        while($row=mysqli_fetch_array($res)){
                            $sql2 ='select * from laptops2 where id ='.$row['ProductID'].'';
                            $res2 = mysqli_query($connection,$sql2);
                            while($row2=mysqli_fetch_array($res2)){
                                echo '<tr>
                                <td class="align-middle">'.$row2['manufacturer'].' - '.$row2['model_name'].'</td>
                                <td class="align-middle">$'.$row2['price'].'</td>
                                <td class="align-middle">
                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-minus" >
                                            <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" class="form-control form-control-sm bg-secondary text-center" value="1">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-plus">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">$150</td>
                                <form method="post" action="Deletefromcart.php">
                                <td class="align-middle"><button value=l'.$row['Id'].'  name="Delete" class="btn btn-sm btn-primary"><i class="fa fa-times"></i></button></td>
                                </form>
                            </tr>';
                            }
                            
                        }
                        $sql ='select * from hardwareshoppingcart where UserId  = '.$_SESSION['UserID'].'';
                        $res = mysqli_query($connection,$sql);
                        while($row=mysqli_fetch_array($res)){
                            $sql2 ='select * from hardware where Id ='.$row['HardwareId'].'';
                            $res2 = mysqli_query($connection,$sql2);
                            while($row2=mysqli_fetch_array($res2)){
                                echo '<tr>
                                <td class="align-middle">'.$row2['Name'].'</td>
                                <td class="align-middle">$'.$row2['Price'].'</td>
                                <td class="align-middle">
                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-minus" >
                                            <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" class="form-control form-control-sm bg-secondary text-center" value="1">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-plus">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">$150</td>
                                <form method="post" action="Deletefromcart.php">
                                <td class="align-middle"><button value=h'.$row['Id'].'  name="Delete" class="btn btn-sm btn-primary"><i class="fa fa-times"></i></button></td>
                                </form>
                            </tr>';
                            }
                        }
                        
                        
                        ?>
                      

                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <form class="mb-5" action="addToOrder.php">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Cart Summary</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Subtotal</h6>
                            <h6 class="font-weight-medium">$150</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <h6 class="font-weight-medium">$10</h6>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <h5 class="font-weight-bold">$160</h5>
                        </div>
                        <button class="btn btn-block btn-primary my-3 py-3">Proceed To Checkout</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Cart End -->


   <?php include 'footer1.php'?>