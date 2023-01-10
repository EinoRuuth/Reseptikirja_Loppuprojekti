<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            background-color: #90EE90;
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
        .homma p {
            width:45%;
            margin-left:30px;
            padding:5px;
            display:inline;
            float:left;
            height:250px;
            border-style:solid;
            border-radius:10px;
        }
    </style>
</head>
<body>
    <?php session_start();
    include 'dbConfig.php'; ?>
   <div class="topnav">
    <a href="/php/etusivu.php">Einon sopat</a>
    <a href="/php/reseptihaku.php">Reseptihaku</a>
    <?php if (isset($_SESSION["käyttäjänimi"])) { ?>
        <a href="/php/kirjoitaresepti.php">Kirjoita resepti</a>
    <?php } ?>
    <?php if (isset($_SESSION["id"])) {
            if ($_SESSION["id"] == "4704413142") { ?>
            <a class="active" href="/php/palautteet.php">Lue palateet</a>
        <?php } } ?>
    <?php if (isset($_SESSION["käyttäjänimi"])) { $knimi = $_SESSION["käyttäjänimi"] ?>
    <div class="dropdown">
        <button class="dropbtn"><?php echo $knimi; ?>
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content">
            <?php if (isset($_SESSION["käyttäjänimi"])) { ?>
            <a href="?page=uloskirjaudu">Kirjaudu ulos</a>
            <?php } ?>
            <?php if (isset($_SESSION["käyttäjänimi"])) { ?>
            <a href="/php/kirjoitapalaute.php">Lähetä Palautetta</a>
            <?php } ?> 
            <?php if (isset($_SESSION["id"])) {
            if ($_SESSION["id"] == "4704413142") { ?>
            <a href="/php/redirect.php">Ylläpitäjä</a>
            <?php } } ?>
            <?php }else{ ?>
            <a href="/php/kirjautuminen.php">Kirjaudu sisään</a>
            <?php } ?>
        </div>
    </div>
    </div>
    <?php
    if ($_SESSION["id"] == "4704413142") {
    } else {
        header("Location: /php/etusivu.php");
        exit();
    }
    if (isset($_GET["page"])) {
        $link = $_GET["page"];
        if ($link == 'uloskirjaudu') {
            session_destroy();
            header("Location: /php/etusivu.php");
            exit();
        }
        }
    $hakusql = "SELECT * FROM palaute";
    $tulokset = $yhteys->query($hakusql);
    if ($tulokset->num_rows>0) {
        while($rivi=$tulokset->fetch_assoc()) {
            $otsikko = $rivi["otsikko"];
            $kuvaus = $rivi["kuvaus"];
            $array = $otsikko . '$' . $kuvaus;
                    $kaikki[] = $array;
        }
        $montako = count($kaikki);
    } else {
        echo "ei löydy";
    }
    ?>
    <div class="homma">
    <?php $numero = 1; 
        for ($x = 0; $x < $montako; $x++) {
            $Paikka = $kaikki[$montako-$numero];
        ?>
        <p><?php $palaset = $Paikka; $palasina = explode("$", $palaset); echo $palasina[0]; echo "<br>";echo "<br>"; echo $palasina[1]; $numero = $numero + 1;?></p>
        <?php }?>
    </div>
</body>
</html>