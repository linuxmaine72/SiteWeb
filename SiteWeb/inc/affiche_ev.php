<?php
// codé par Nordine
// 11/11/2012 : modifié par Bertrand
//setlocale(LC_TIME, "fr_FR"); // string date en francais
setlocale (LC_TIME, 'fr_FR.utf8','fra'); // modif Bertrand : pour que le nom du jour s'affiche en Français
$strSTART="";   // initialisation des variables
$strEND="";
$strResume="";
$strURL="";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://www.agendadulibre.org/ical.php?tag=linuxmaine"); // recup fichier ical dans variable
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch); //Fermeture du gestionnaire cURL juste après exécution
    $pieces = explode("\n", $output); // chaque lignes dans une case du tableau $pieces
    $i=1;
    foreach ($pieces as $lineContent1)
    { 
	$lineContent2=$pieces[$i-10];
	$pars1=explode(":",$lineContent1); // chaque mot de la ligne séparé par : dans une case du tableau de chaine $pars1
	$pars2=explode(":",$lineContent2); // chaque mot de la ligne (de l'évenement antérieur) séparé par : dans une case du tableau de chaine $pars2
	if (strpos($lineContent1, "DTSTART")===0)	{$strSTART1=$pars1[1]; $strSTART2=$pars2[1];}
        if (strpos($lineContent1, "DTEND")===0)		{$strEND1=$pars1[1]; $strEND2=$pars2[1];}
        if (strpos($lineContent1, "SUMMARY")===0)	{$strResume1 = $pars1[1];  $strResume2=$pars2[1];}
        if (strpos($lineContent1, "URL")===0)		{$strURL1=$pars1[1].":".$pars1[2]; $strURL2=$pars2[1].":".$pars2[2];}
	$i=$i+1;
   	 }
    $strSTART1Annee = substr($strSTART1,0,4);
    $strSTART1Mois = substr($strSTART1,4,2);
    $strSTART1Jour = substr($strSTART1,6,2);
    $strSTART1Heure = substr($strSTART1,9,2);
    $strSTART1Min = substr($strSTART1,11,2);
    $strEND1Heure = substr($strEND1,9,2);
    $strEND1Min = substr($strEND1,11,2);
    $strDATE1="$strSTART1Mois/$strSTART1Jour/$strSTART1Annee";

    $strSTART2Annee = substr($strSTART2,0,4);
    $strSTART2Mois = substr($strSTART2,4,2);
    $strSTART2Jour = substr($strSTART2,6,2);
    $strSTART2Heure = substr($strSTART2,9,2);
    $strSTART2Min = substr($strSTART2,11,2);
    $strEND2Heure = substr($strEND2,9,2);
    $strEND2Min = substr($strEND2,11,2);
    $strDATE2="$strSTART2Mois/$strSTART2Jour/$strSTART2Annee";

    echo "<a href='$strURL2' target='_blank' >";
    echo strftime("%A %e %B %Y",strtotime($strDATE2));
    echo " de ".$strSTART2Heure."h".$strSTART2Min." à ".$strEND2Heure."h".$strEND2Min."</BR>";
    echo "</a>";
    echo "<a href='$strURL1' target='_blank' >";
    echo strftime("%A %e %B %Y",strtotime($strDATE1));
    echo " de ".$strSTART1Heure."h".$strSTART1Min." à ".$strEND1Heure."h".$strEND1Min."</BR>";
    echo "</a>";

?>
