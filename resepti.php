<!DOCTYPE html>
<html>
<head>
    <?php
    session_start();
    include 'dbConfig.php';
    $halutturesepti = $_GET['resepti'];
    $haluttutekijä = $_GET['tekija'];
    $hakusql = "SELECT * FROM resepti WHERE nimi LIKE '$halutturesepti' AND kirjoittaja LIKE '$haluttutekijä'";
		$tulokset = $yhteys->query($hakusql);
		if ($tulokset->num_rows>0) {
            while($rivi=$tulokset->fetch_assoc()) {
                $id = $rivi["reseptiid"];
                $imageURL = $rivi["kuva"];
                $ruokalaji = $rivi["ruokalaji"];
                $ainekset = $rivi["ainekset"];
                $valmistusohje = $rivi["valmistuohje"];
            } }
    ?>
    <style>
        body {
            background-color:#2E8B52;
            background-image: linear-gradient(rgba(0, 0, 0, 0.5),
                       rgba(0, 0, 0, 0.5)), url("uploads/<?php echo $imageURL; ?>");
            background-repeat:no-repeat;
            background-attachment: fixed;
            background-size: cover;
            background-size: 100% 100%;
            color: white;
        }
        h1 {
            text-align:center;
        }
        .ohje {
            width:50%;
            display:inline;
            float:left;
        }
        .ohje > p {
            font-size: 25px;
        }
        .aineet > p {
            font-size: 25px;
        }
        .aineet{
            width:50%;
            display:inline;
            float:left;
        }
        .topnav {
            background-color: #333;
            overflow: hidden;
        }
        .topnav a {
            float: left;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
        }
        .topnav a:hover {
            background-color: #ddd;
            color: black;
        }
        .topnav a.active {
            background-color: #04AA6D;
            color: white;
        }
        .dropdown {
            float: left;
            overflow: hidden;
        }
        .dropdown .dropbtn {
            font-size: 16px;
            border: none;
            outline: none;
            color: white;
            padding: 14px 16px;
            background-color: inherit;
            font-family: inherit;
            margin: 0;
        }
        .navbar a:hover, .dropdown:hover .dropbtn {
            background-color: red;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }
        .dropdown-content a {
            float: none;
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
        }
        .dropdown-content a {
            background-color: #333;
            color:white;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
</head>
<body>
    <?php
    if (isset($_POST["poista"])) {
        $_SESSION["poistaid"] = $id;
        header("Location: /php/redirect.php");
        exit();
    }
    ?>
    <div class="topnav">
    <a href="/php/etusivu.php">Einon sopat</a>
    <a class="active" href="/php/reseptihaku.php">Reseptihaku</a>
    <?php if (isset($_SESSION["käyttäjänimi"])) { ?>
        <a href="/php/kirjoitaresepti.php">Kirjoita resepti</a>
    <?php } ?>
    <?php if (isset($_SESSION["käyttäjänimi"])) { $knimi = $_SESSION["käyttäjänimi"] ?>
    <div class="dropdown">
        <button class="dropbtn"><?php echo $knimi; ?>
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content">
            <?php if (isset($_SESSION["käyttäjänimi"])) { ?>
            <a href="?page=uloskirjaudu">Kirjaudu ulos</a>
            <?php } ?> 
            <?php if (isset($_SESSION["id"])) {
            if ($_SESSION["id"] == "4704413142") { ?>
            <a href="/php/redirect.php">Ylläpitäjä</a>
            <?php } }?>
        </div>
    </div>
    <?php }else{ ?>
        <a href="/php/kirjautuminen.php">Kirjaudu sisään</a>
        <?php } ?>
</div>
    <h1><?php echo $halutturesepti; ?></h1>
    <div class="aineet">
        <p>ainekset</p>
        <?php
            echo $ainekset;
        ?>
    </div>
    <div class="ohje">
        <p>valmistusohje</p>
        <?php
            echo $valmistusohje;
        ?>
    </div>
    <?php if ($_SESSION["id"] == "4704413142") { ?>
        <form method="post">
        <input type="submit" name="poista" value="Poista resepti">
        </form>
    <?php } ?>
        <?php
    if (isset($_GET["page"])) {
    $link = $_GET["page"];
    if ($link == 'uloskirjaudu') {
        session_destroy();
        header("Location: /php/etusivu.php");
        exit();
    }
    }
?>
</body>
</html>