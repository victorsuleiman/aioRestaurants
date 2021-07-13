<?php

    class FileAgent{

        public static function createFile($dataContent){
            $header = [
                "ProductId",
                "ProductName",
                "Unit",
                "SupplierId",
                "Quantity",
                "Price",
                "Category",
                "EntryDate"
            ];

            try{
                $fileHandle = fopen(DATA_OUTPUT,'w+');

                if(!$fileHandle){
                    throw new Exception("Error writing the file report!");
                } else {
                    //Write the String inside the file
                    fputcsv($fileHandle,$header,"\t");

                    for($i = 0; $i < count($dataContent); $i++){
                        $line = [
                            $dataContent[$i]->getProductId(),
                            $dataContent[$i]->getProductName(),
                            $dataContent[$i]->getUnit(),
                            $dataContent[$i]->getSupplierId(),
                            $dataContent[$i]->getQuantity(),
                            $dataContent[$i]->getPrice(),
                            $dataContent[$i]->getCategory(),
                            $dataContent[$i]->getEntryDate()
                        ];
                        fputcsv($fileHandle,$line,"\t");
                    }

                    //*IMPORTANT* Close the file
                    fclose($fileHandle);
                }
            } catch (Exception $errorMessage){
                echo $errorMessage->getMessage();
            }
        }
    }