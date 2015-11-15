<?php

// codé par Nordine
// modifié par Bertrand
// 23 septembre 2013 Nordine :  ajout d'un timeout en cas de non réponse du serveur agendadulibre.org
//setlocale(LC_TIME, "fr_FR"); // string date en francais
setlocale (LC_TIME, 'fr_FR.utf8','fra'); // modif Bertrand : pour que le nom du jour s'affiche en Français

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://www.agendadulibre.org/maps.json?tag=linuxmaine"); // recup fichier ical dans variable
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 3);
$output = curl_exec($ch);

if ($output) {
    curl_close($ch); //Fermeture du gestionnaire cURL juste après exécution
    $parsed_json = json_decode($output);

    foreach ($parsed_json as $tabJson) {
        $intID=$tabJson->{'properties'}->{'id'} ;
        $strName = $tabJson->{'properties'}->{'name'} ;
        $strDebut = $tabJson->{'properties'}->{'start_time'};
        $strFin = $tabJson->{'properties'}->{'end_time'};
        
        $strDate = strftime("le %A %e %B %Y", strtotime($strDebut)) ;
        $strHeure =  "de ".strftime("%kh%M", strtotime($strDebut)) . " à " . strftime("%kh%M", strtotime($strFin));
        
        echo "<a href='http://www.agendadulibre.org/events/$intID' target='_blank' >";
        echo "<p>$strName</p>";
        echo "<p>$strDate</p>";
        echo "<p>$strHeure</p>";
        
        //echo " de ".$date->format('j-n-Y')." à ".$date->format('j-n-Y')."</BR>";
        echo "</a>";
    }
}
?>
