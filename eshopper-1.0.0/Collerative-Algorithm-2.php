



<?php
include 'DBconn.php';


//Gathering DataSet
$sql = "SELECT DISTINCT(item_id) FROM `user_ratings` ";
$result = mysqli_query($connection,$sql);
$items_Rating = array();
while($row=mysqli_fetch_array($result)){
    $sql2 = 'SELECT rating FROM `user_ratings` WHERE item_id  = '.$row["item_id"].'';
    $result2 = mysqli_query($connection,$sql2);
    while($row2=mysqli_fetch_array($result2)){
        $items_Rating[$row["item_id"]][] = $row2["rating"];    
    }
}


//make function to do a Centered vectors
function CenteredOfRattingItem($items_Rating)
{

    foreach ($items_Rating as $rate => $users) {
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
            
            $items_Rating[$rate]= $users;
    
        }
    
        return $items_Rating;
    
}

$items_Rating2= CenteredOfRattingItem($items_Rating);



// $items_Rating2 = array(
//     1 => array(1.0,0.0,3.0,0.0,0.0,5.0,0.0,0.0,5.0,0.0,4.0,0.0),
//     2 => array(0.0,0.0,5.0,4.0,0.0,0.0,4.0,0.0,0.0,2.0,1.0,3.0),
//     3 => array(2.0,4.0,0.0,1.0,2.0,0.0,3.0,0.0,4.0,3.0,5.0,0.0),
//     4 => array(0.0,2.0,4.0,0.0,5.0,0.0,0.0,4.0,0.0,0.0,2.0,0.0),
//     5 => array(0.0,0.0,4.0,3.0,4.0,2.0,0.0,0.0,0.0,0.0,2.0,5.0),
//     6 => array(1.0,0.0,3.0,0.0,3.0,0.0,0.0,2.0,0.0,0.0,4.0,0.0)
// );

// foreach($items_Rating2 as $key=>$value){
//     foreach($value as $key2=>$value2){
//         if($items_Rating[$key][$key2]!=$value2){
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

    $items_Rating_User = array();
    $query_get_items = mysqli_query($connection,"SELECT `item_id` FROM `user_ratings` WHERE `user_id`='$userId' and `rating` != 0");
    
    while($row = mysqli_fetch_assoc($query_get_items))
    {
        array_push($items_Rating_User,$row['item_id']);
    }

    return $items_Rating_User;
    

}

//from session.
$predict_Item_user = 5;





function Get_Recommend_Item($items_Rating,$item,$nearNeighborItem)
{
    //this item will be recommend for user
    $recommendItem = 0;
    $items_Similarity = [];

    foreach ($nearNeighborItem as $item_Neighbor) {
        $items_Similarity[$item_Neighbor] = round(similarity_item($items_Rating[$item],$items_Rating[$item_Neighbor]),5);
    
    }

    $recommendItem  = array_search(max($items_Similarity),$items_Similarity);
    
    return [$recommendItem,$items_Similarity[$recommendItem]];
}
    

    // foreach ($neighborhood as $k_neighbor) {
    //     $items_Similarity[$k_neighbor] = round(similarity_item($items_Rating[$items_Predict[0]], $items_Rating[$k_neighbor]),5);
    // }

$ItemOfRecommendation = [];

//get all item that user not rated until now aka ratting = 0.
$items_Predict = Get_All_Predict_Items($predict_Item_user);

//get all item that user  rated until now aka ratting != 0.
$items_Rating_User = Get_All_Ratting_Items_byUser($predict_Item_user);


foreach($items_Predict as $item)
{

    $itemOfRecommendation[$item] = Get_Recommend_Item($items_Rating,$item,$items_Rating_User);

}




// echo "<pre>";
// print_r($items_Predict);
// echo "</pre>";





// $countOfRate = 0;


    // echo "<pre>";
    // print_r($items_Rating);
    // echo "</pre>";


function similarity_item($item1, $item2) {
    $item1_Common = [];
    $item2_Common = [];

    foreach (array_combine($item1, $item2) as $rate_item1 => $rate_item2) {
        if ($rate_item1 != 0 && $rate_item2 != 0) {
            $item1_Common[] = $rate_item1;
            $item2_Common[] = $rate_item2;
        }
    }

    $dot_Product = array_sum(array_map(function($a, $b) { return $a * $b; }, $item1_Common, $item2_Common));

    $length_vector1 = array_sum(array_map(function($a) { return $a * $a; }, $item1_Common));
    $length_vector2 = array_sum(array_map(function($a) { return $a * $a; }, $item2_Common));

    return $dot_Product / sqrt($length_vector1 * $length_vector2);
}

//all item the user not rated 





// echo"<hr>";
// $id_Item  = array_search(max($items_Similarity),$items_Similarity);

// echo $id_Item;

echo "<pre>";
print_r($items_Similarity);
echo "</pre>";

?>