<?php
    //Function to count (x1 - x2)^2 , (y1-y2)^2 , etc

function forMin($sample,  $predictData,$Minn=0)
    {

        $lengthPredict = count($predictData);
        $length = count($sample);
        echo "lengthPredict: $lengthPredict<br>";
        echo "length: $length<br>";



        for ($i = 0; $i < $length; $i++) {
            for ($j = 0; $j < $lengthPredict; $j++) {
                if(gettype($predictData[$j])=="string"){
                    if($predictData[$j]==$sample[$i][$j]){
                        $resultForMin[$i][$j] = 0;
                    }
                    else{
                        if($sample[$i][$j]=="Notebook"||$sample[$i][$j]=="Gaming"||
                        $sample[$i][$j]=="Ultrabook"||$sample[$i][$j]=="2 in 1 Convertible"||
                        $sample[$i][$j]=="Workstation"||$sample[$i][$j]=="Netbook"){
                        $resultForMin[$i][$j] = pow($predictData[1]-$Minn-1,2);

                        }
                        else if($sample[$i][$j]=="Apple" || $sample[$i][$j]=="Dell"|| 
                        $sample[$i][$j]=="Lenovo"|| $sample[$i][$j]=="HP"|| 
                        $sample[$i][$j]=="MSI"|| $sample[$i][$j]=="Acer"|| 
                        $sample[$i][$j]=="Asus"|| $sample[$i][$j]=="Razer"|| 
                        $sample[$i][$j]=="Microsoft"|| $sample[$i][$j]=="Toshiba"|| 
                        $sample[$i][$j]=="Samsung"|| $sample[$i][$j]=="Razer"|| 
                        $sample[$i][$j]=="Mediacom"|| $sample[$i][$j]=="Xiaomi"|| 
                        $sample[$i][$j]=="Google"|| $sample[$i][$j]=="Chuwi"|| 
                        $sample[$i][$j]=="Fujitsu"|| $sample[$i][$j]=="LG"|| 
                        $sample[$i][$j]=="Huawei" ){
                            $resultForMin[$i][$j] = pow($predictData[1]-$Minn+1,2);
                        }
                        else if($sample[$i][$j]=="2GB" || $sample[$i][$j]=="4GB"||
                        $sample[$i][$j]=="6GB" || $sample[$i][$j]=="8GB"||
                        $sample[$i][$j]=="12GB" || $sample[$i][$j]=="16GB"||
                        $sample[$i][$j]=="24GB" || $sample[$i][$j]=="32GB"||
                        $sample[$i][$j]=="64GB"){
                            $resultForMin[$i][$j] = pow($predictData[1]-$Minn+2,2);

                        } 
                        else{
                                $resultForMin[$i][$j] = pow($predictData[1]-$Minn+$j,2);

                            }
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
