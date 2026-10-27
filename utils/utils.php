<?php 

function formatJoueur($min , $max){
    switch(true){
        case $max == 1 : $result = "Solo"; break;
        case $max == $min : $result = $max." joueurs"; break;
        default: $result = $min." à ".$max." joueurs";
    }
    return $result;
}

function categorieDuree($duree){
    switch(true){
        case $duree < 30 : $result = "Partie rapide"; break;
        case $duree <= 90 : $result = "Partie moyenne"; break;
        case $duree > 90 : $result = "Partie longue"; break;
        default: $result = "Durée invalide";
    }
    return $result;
}

?>