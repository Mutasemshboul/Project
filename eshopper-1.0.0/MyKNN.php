<?php
    //Function to count (x1 - x2)^2 , (y1-y2)^2 , etc

function forMin($sample,  $predictData,$Minn=0)
    {

        $lengthPredict = count($predictData);
        $length = count($sample);
        
        for ($i = 0; $i < $length; $i++) {
            for ($j = 0; $j < $lengthPredict; $j++) {
                if(gettype($predictData[$j])=="string"){
                    if($predictData[$j]==$sample[$i][$j]){
                        $resultForMin[$i][$j] = 0;
                    }

                    else{
                        $resultForMin[$i][$j] = pow($predictData[1]-$Minn+$j,2);

                     }
                    
                }
                else{
                    $resultForMin[$i][$j] = pow($predictData[$j] - $sample[$i][$j], 2);

                }
                
            }
            $resultForMin[$i][] = $sample[$i][$lengthPredict];
        }

        $sendToSquare = square($resultForMin, $length, $lengthPredict);
        $result = getLable($sendToSquare);
        return $result;


    }


    function square($srcData, $srcLength, $srcPredictDataLength)
    {

        for ($i = 0; $i < $srcLength; $i++) {

            $resultSquare[] = [sqrt(array_sum($srcData[$i])),$srcData[$i][$srcPredictDataLength]];
        }
        sort($resultSquare);
        return $resultSquare;
    }

    function getLable($result){
        return $result;
    }

    //Category 
 $s=[["fridge",899 ,1],["Labtop",899 ,2],["Labtop",800,5],["Labtop",500,9]];
$pr = ["Busneis",900];

// print_r(forMin($s,$pr)) ;












?>
