<?php
setlocale(LC_TIME, "fr_FR");
$strSTART="";
$strEND="";
$strResume="";
$strURL="";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://www.agendadulibre.org/ical.php?tag=linuxmaine");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $pieces = explode("\n", $output);
    
    foreach ($pieces as $lineContent) {
$pars=explode(":",$lineContent);

if (strpos($lineContent, "DTSTART")===0) {$strSTART=$pars[1]; }
        if (strpos($lineContent, "DTEND")===0) {$strEND=$pars[1];}
        if (strpos($lineContent, "SUMMARY")===0) {$strResume = $pars[1];}
        if (strpos($lineContent, "URL")===0) { $strURL=$pars[1].":".$pars[2];}
    }
    $strSTARTAnnee = substr($strSTART,0,4);
    $strSTARTMois = substr($strSTART,4,2);
    $strSTARTJour = substr($strSTART,6,2);
    $strSTARTHeure = substr($strSTART,9,2);
    $strSTARTMin = substr($strSTART,11,2);
    $strENDHeure = substr($strEND,9,2);
    $strENDMin = substr($strEND,11,2);
    $strDATE="$strSTARTMois/$strSTARTJour/$strSTARTAnnee";
    echo "<a href='$strURL' target='_blank' >";
    echo strftime("%A %e %B %Y",strtotime($strDATE));
    echo " de ".$strSTARTHeure."h".$strSTARTMin." à ".$strENDHeure."h".$strENDMin."</BR>";
    echo "</a>";
    curl_close($ch);
?>
