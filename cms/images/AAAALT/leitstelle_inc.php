<?php
session_start();
error_reporting(0);

include("./functions/header1.php");
include("./actions/leitactions.php");


if ($_SESSION['lst-seite'] == "fmsliste2"){
$statussichtbar = "2";
include ("./includes/lst.php");
} 

elseif ($_SESSION['lst-seite'] == "fmsliste"){
$statussichtbar = "o";
include ("./includes/lst.php");
}

elseif ($_SESSION['lst-seite'] == "fmslog"){
include ("./includes/fms-logger.php");
}

elseif ($_SESSION['lst-seite'] == "einsatzliste"){
include ("./includes/lstliste.php");} 

elseif ($_SESSION['lst-seite'] == "einsatzliste2"){
include ("./includes/lstliste2.php");} 
?>



