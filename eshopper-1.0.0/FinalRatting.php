

<?php


include 'DBconn.php';



//user id
$userID = $_SESSION['UserID'];


$_SESSION['ItemDelete'];
$_SESSION['ItemView'];
$_SESSION['ItemBuy'];

//product id

$map = [];
$i=0;
foreach ($_SESSION['ItemDelete'] as $item => $type) {
    $map[$i] = [$item,$type];
    $i++;
}


foreach ($_SESSION['ItemView'] as $item => $type) {
    $map[$i] = [$item,$type];
    $i++;
}

foreach ($_SESSION['ItemBuy'] as $item => $type) {
    $map[$i] = [$item,$type];
    $i++;
}


echo "<pre>";
print_r($map);
echo "</pre>";

// // $arr = array_merge_recursive(
// //     $_SESSION['ItemDelete'],[1 , 2, 3 , 5, 7 ]
// //     $_SESSION['ItemDelete'],[1 , 5, 7 ]
// //     $_SESSION['ItemView'],
// //     $_SESSION['ItemBuy'][1 , 5, 7, 4 , 7]
// // );


foreach($map  as $index => $item)
{
    $prodID =$item[0];
    $type = $item[1];

    $finalRattingItem = 0;
    $isItemBought=false;
    $isItemCartDelete=false;
    $isItemView=false;
    $isItemGood=false;


    //Item Delete
    if(array_key_exists($prodID,$_SESSION['ItemDelete']))
            $isItemCartDelete=true;

    if(array_key_exists($prodID,$_SESSION['ItemView']))
            $isItemView=true;

    if(array_key_exists($prodID,$_SESSION['ItemBuy']))
            $isItemBought=true;

    

    $avg =0;
    $c=0;
    if($type=='l'){

        $q ="SELECT `rating` FROM `user_ratings` WHERE `item_id`='$prodID' and (`rating` != '0' and `Type`='L')";
        
        $query = mysqli_query($connection,$q);

        while ($row = mysqli_fetch_assoc($query)) {
            
            $c++;
            $avg += $row['rating']; 
        }
        if($c!=0)
            $avg= $avg/ $c;
    }

    else{

        $q ="SELECT `rating` FROM `user_ratings` WHERE `item_id`='$prodID' and (`rating` != '0' and `Type`='L') ";
        
        $query = mysqli_query($connection,$q);

        while ($row = mysqli_fetch_assoc($query)) {
            
            $c++;
            $avg += $row['rating']; 
        }
        if($c!=0)
            $avg= $avg/ $c;

    }

    if($avg >= 3 )
        $isItemGood=true;



    
   

   
            /*
            ★★★★★ = Masterpiece / Top Favorite

            ★★★★½ = Excellent / Favorite

            ★★★★☆ = Great / Loved It

            ★★★½☆ = Good / Liked It

            ★★★☆☆ = Decent / It Was Ok

            ★★½☆☆ = Mediocre / Did Not Like It

            ★★☆☆☆ = Bad

            ★½☆☆☆ = Terrible

            ★☆☆☆☆ = Hate It

            ♡ = Would watch it again

            */
            //S1-buy
            //Masterpiece / Top Favorite
            if($isItemBought && !$isItemCartDelete  && !$isItemView)
            {
            // 4 + 1
            //★★★★★
            if($isItemGood){

            $finalRattingItem = 5;
            }
            //4 + 0
            //★★★★☆
            else
            {
            $finalRattingItem = 4;
            }
            }

            //S2-buy
            //Excellent / Favorite
            else if($isItemBought && $isItemCartDelete  && !$isItemView)
            {
            // (3 + 4)/2 + 1 
            //★★★★½ 
            if($isItemGood){

            $finalRattingItem = 4.5;
            }
            //★★★½☆ = Good / Liked It
            else
            {
            $finalRattingItem = 3.5;
            }
            }

            //S3-buy
            //★★★☆☆ = Decent / It Was Ok
            else if($isItemBought && $isItemCartDelete  && $isItemView)
            {
            // (2 + 3 + 3)/3 + 1 
            //★★★☆☆ = Decent / It Was Ok
            if($isItemGood){

            $finalRattingItem = 3;
            }
            //(3 + 4)/2 + 0
            //★★½☆☆ = Mediocre / Did Not Like It
            else
            {
            $finalRattingItem = 2.6;
            }
            }
            //////////////////////////////////////////////////////////////////////////
            // if not buy ---> good item :0.5

            //S4-Not buy

            else if(!$isItemBought && $isItemCartDelete  && !$isItemView)
            {
            // 2.5 + 0.5
            //★★★☆☆ = Decent / It Was Ok
            if($isItemGood){

            $finalRattingItem = 3;
            }
            //2.5 + 0 
            //★★½☆☆ = Mediocre / Did Not Like It
            else
            {
            $finalRattingItem = 2.5;
            }
            }


            else if(!$isItemBought && $isItemCartDelete  && $isItemView)
            {
            // (2.5 + 2)/2 + 0.5
            //★★½☆☆ = Mediocre / Did Not Like It
            if($isItemGood){

            $finalRattingItem = 2.7;
            }
            //(2.5 + 2)/2 
            //★★☆☆☆ = Bad
            else
            {
            $finalRattingItem = 2.2;
            }
            }
            

            echo $finalRattingItem. "    ".$prodID."<br>"; 
            $q = mysqli_query($connection,"INSERT INTO `recommend_items`(`userID`, `ItemID`, `rating`,`Type`) VALUES ('$userID','$prodID','$finalRattingItem','$type')");

            


}



?>