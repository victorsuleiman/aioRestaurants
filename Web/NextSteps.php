<?php
    $nextSteps = [];

    $nextSteps[] = "Fragmentar as funções de Conversão STD e em Entidade";
    $nextSteps[] = "Criar um DAO para cada entidade";
    $nextSteps[] = "Criar os HTML para os charts e reports";
    $nextSteps[] = "Criar o Rest API";
    
    for($i = 0; $i < count($nextSteps); $i++){
        $count = $i + 1;
        echo "$count - $nextSteps[$i].\n";
    }