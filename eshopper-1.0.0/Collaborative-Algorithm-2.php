



<?php
include 'DBconn.php';


//Gathering Dataset
$sql = "SELECT DISTINCT(item_id) FROM `user_ratings` ";
$result = mysqli_query($connection,$sql);
$items_Ratting = array();
while($row=mysqli_fetch_array($result)){
    $sql2 = 'SELECT rating FROM `user_ratings` WHERE item_id  = '.$row["item_id"].'';
    $result2 = mysqli_query($connection,$sql2);
    while($row2=mysqli_fetch_array($result2)){
        $items_Ratting[$row["item_id"]][] = $row2["rating"];    
    }
}

//make function to do a Centered vectors
function CenteredOfRattingItem($items_Ratting)
{

    foreach ($items_Ratting as $rate => $users) {
        $rate_Mean = 0;
        $countOfRate = 0;
    
        foreach ($users as $users_rate) {
            if ($users_rate != 0) {
                $countOfRate += 1;
            }
        }
    
        $rate_Mean = array_sum($users) / $countOfRate;
    
    
            for ($i=0; $i <count($users); $i++) { 
                
                if ($users[$i] != 0) {
    
                    $users[$i] = $users[$i]-$rate_Mean;
                    
                    
                }
    
            }
            
            $items_Ratting[$rate]= $users;
    
        }
    
        return $items_Ratting;
    
}

// echo "<pre>";
// print_r($items_Ratting);
// echo "</pre>";

$items_Ratting2= CenteredOfRattingItem($items_Ratting);



//Test Data
// $items_Ratting2 = array(
//     1 => array(1.0,0.0,3.0,0.0,0.0,5.0,0.0,0.0,5.0,0.0,4.0,0.0),
//     2 => array(0.0,0.0,5.0,4.0,0.0,0.0,4.0,0.0,0.0,2.0,1.0,3.0),
//     3 => array(2.0,4.0,0.0,1.0,2.0,0.0,3.0,0.0,4.0,3.0,5.0,0.0),
//     4 => array(0.0,2.0,4.0,0.0,5.0,0.0,0.0,4.0,0.0,0.0,2.0,0.0),
//     5 => array(0.0,0.0,4.0,3.0,4.0,2.0,0.0,0.0,0.0,0.0,2.0,5.0),
//     6 => array(1.0,0.0,3.0,0.0,3.0,0.0,0.0,2.0,0.0,0.0,4.0,0.0)
// );

// foreach($items_Ratting2 as $key=>$value){
//     foreach($value as $key2=>$value2){
//         if($items_Ratting[$key][$key2]!=$value2){
//             echo"NotEquals ";
//             echo $key.'   '.$key2.'   '.$value2.'<br>';
        
            
//         }
//     }
// }





function Get_All_Predict_Items($userId)
{
    global $connection;

    $items_Predict = array();
    $query_get_items = mysqli_query($connection,"SELECT `item_id` FROM `user_ratings` WHERE `user_id`='$userId' and `rating`=0");
    
    while($row = mysqli_fetch_assoc($query_get_items))
    {
        array_push($items_Predict,$row['item_id']);
    }

    return $items_Predict;
    

}


function Get_All_Ratting_Items_byUser($userId)
{
    global $connection;

    $items_Ratting_User = array();
    $query_get_items = mysqli_query($connection,"SELECT `item_id` FROM `user_ratings` WHERE `user_id`='$userId' and `rating` != 0");
    
    while($row = mysqli_fetch_assoc($query_get_items))
    {
        array_push($items_Ratting_User,$row['item_id']);
    }

    return $items_Ratting_User;
    

}


function similarity_item($item1, $item2) {
    $item1_Common = [];
    $item2_Common = [];

    $length = count($item1);

    
    for($pos =0 ; $pos< $length; $pos++)
    {
        if ($item1[$pos] != 0 and $item2[$pos] != 0) {
            $item1_Common[] = $item1[$pos];
            $item2_Common[] = $item2[$pos];
        }
    }
    
  
    

    $dot_Product = array_sum(array_map(function($a, $b) { return $a * $b; }, $item1_Common, $item2_Common));

    $length_vector1 = array_sum(array_map(function($a) { return $a * $a; }, $item1_Common));
    $length_vector2 = array_sum(array_map(function($a) { return $a * $a; }, $item2_Common));

    

    return $dot_Product / sqrt($length_vector1 * $length_vector2);
}



function Get_Recommend_Item($items_Ratting,$item,$nearNeighborItem)
{
    //this item will be recommend for user
    $items_Similarity = [];

    foreach ($nearNeighborItem as $item_Neighbor) {
        
        $similarityValue = round(similarity_item($items_Ratting[$item],$items_Ratting[$item_Neighbor]),5);
        
        //Ignore for Negative Similarity(aka Dissimilarity)  
        if($similarityValue > 0)
        {
            $items_Similarity[$item_Neighbor] = $similarityValue;
        }
        
    
    }

    
    arsort($items_Similarity);

    return $items_Similarity;
}


    


//from session.
$predict_Item_user = $_SESSION['UserID'];
$ItemOfRecommendation = [];


//get all item that user not rated until now aka ratting = 0.
$items_Predict = Get_All_Predict_Items($predict_Item_user);

//get all item that user  rated until now aka ratting != 0.
$items_Ratting_User = Get_All_Ratting_Items_byUser($predict_Item_user);


if(count($items_Ratting_User) <= count($items_Predict) && count($items_Ratting_User)==0)
{
    //echo "<div > New User";
}

else{

    foreach($items_Predict as $item)
    {
    
        $itemOfRecommendation[$item] = Get_Recommend_Item($items_Ratting2,$item,$items_Ratting_User);
    }
    
    //Get the rating that the item will be suggested by the user
    function Get_Recommend_RattingOfItem($itemOfRecommendation,$items_Ratting,$predict_Item_user)
    {
        $rattingOFAllRecommendationItems=array();
        
        foreach($itemOfRecommendation as $item =>$val)
        {
            $rattingOfRecommendItem=0;
            $sumOfWight=0;
            
            $i =0;
            foreach($val as $subItem => $wight)
            {
                if($i==2)break;
    
                $rattingOfRecommendItem += $wight*$items_Ratting[$subItem][$predict_Item_user-1];
    
                $sumOfWight+= $wight;
            }
            //echo $item."<br>";
    
            $rattingOFAllRecommendationItems[$item] =  round($rattingOfRecommendItem/$sumOfWight,2);
            
        }
    
        arsort($rattingOFAllRecommendationItems);
        
        return $rattingOFAllRecommendationItems;
    
    
       
    }
    
    // $recommendItem  = array_search(max($items_Similarity),$items_Similarity);
    // echo "<pre>";
    // print_r($itemOfRecommendation);
    // echo "</pre>";
    //Get_Recommend_RattingOfItem($itemOfRecommendation,$items_Ratting,$predict_Item_user);
    
    echo "<div style='text-align: center;'>";
    
    $rattingOFAllRecommendationItems = Get_Recommend_RattingOfItem($itemOfRecommendation,$items_Ratting,$predict_Item_user);
    
    
    echo "<pre>";
    print_r($rattingOFAllRecommendationItems);
    echo "</pre>";
    
    //get Item
    $getMaxRecommend_RattingOfItem =array_search(max($rattingOFAllRecommendationItems),$rattingOFAllRecommendationItems);
    
    
    echo $getMaxRecommend_RattingOfItem; 
    // echo "<pre>";
    // print_r(Get_Recommend_RattingOfItem($itemOfRecommendation,$items_Ratting,$predict_Item_user));
    // echo "</pre>";
    
    
    echo "</div>";
    
}


?>