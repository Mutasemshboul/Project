

<?php




//user id
$userID = $_SESSION['UserID'];


//product id

$finalRattingItem = 0;
$isItemBought=true;
$isItemCartDelete=true;
$isItemView=false;
$isItemGood=false;

//Delete [1,2,5,7,8]
//View[1,8,2]
//Buy[1,2,4,5]




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

$q = mysqli_query($connection,"INSERT INTO `recommend_items`(`userID`, `ItemID`, `rating`) VALUES ('$userid','$id','$finalRattingItem')");






?>