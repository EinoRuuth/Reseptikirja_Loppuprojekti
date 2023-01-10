<!DOCTYPE hmtl>
<html>
<head>
    <style>
        body {
            background-color: #90EE90;
        }
        form {
            text-align:center;
            padding:10px;
        }
        .homma a {
            width:33%;
            display:inline;
            float:left;
            font-size:20px;
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
        session_start();
        include 'dbConfig.php';
        $kaikki = array();
        if (isset($_POST["reseptit"])) {
            if (isset($_POST["reseptiname"])) {
                $nimi = $_POST["reseptiname"];
                $hakusql = "SELECT * FROM resepti WHERE nimi LIKE '%$nimi%'";
            }
            if (isset($_POST["ainesnimi"])) {
                $aines = $_POST["ainesnimi"];
                $hakusql = "SELECT * FROM resepti WHERE ainekset LIKE '%$aines%'";
            }
            if (isset($_POST["lajiname"])) {
                $laji = $_POST["lajiname"];
                $hakusql = "SELECT * FROM resepti WHERE ruokalaji LIKE '%$laji%'";
            }
		    $tulokset = $yhteys->query($hakusql);
		    if ($tulokset->num_rows>0) {
                while($rivi=$tulokset->fetch_assoc()) {
                    $hakunimi = $rivi["nimi"];
                    $kirjoittaja = $rivi["kirjoittaja"];
                    $array = $hakunimi . ' ' . $kirjoittaja;
                    $kaikki[] = $array;
            }
            foreach ($kaikki as $value) {
            }
            $montako = count($kaikki);

            } else {
                $montako = 0;
            }
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
    <form method="post">
    <?php if (isset($_POST["hakutaapa"])) {
    } else { ?>
        <select name="hakutapa">
            <option value="nimi2">Hae nimen mukaan</option>
            <option value="aines2">Hae aineksen mukaan</option>
            <option value="laji2">Hae ruokalajin mukaan</option>
        </select>
        <input type="submit" name="hakutaapa">
        <br><br>
        <?php } ?>
        <?php if (isset($_POST["hakutaapa"])) {
            $value2 = $_POST["hakutapa"];
            if ($value2 == 'nimi2') {?>
                <input type="text" name="reseptiname" placeholder="Kirjoita reseptin nimi">
            <?php }
            if ($value2 == 'aines2') {?>
                <input type="text" name="ainesnimi" placeholder="Kirjoita aineksen nimi">
            <?php }
            if ($value2 == 'laji2') {?>
                <select name="lajiname">
                    <option value="alkuruoka">Alkuruoka</option>
                    <option value="pääruoka">Pääruoka</option>
                    <option value="jälkiruoka">Jälkiruoka</option>
                </select>
            <?php } ?>
            <p></p>
            <input type="submit" name="reseptit" value="Hae" style="height:30px; width:80px;">
            <?php
        } ?>
    
    </form>
        <div class="homma">
        <?php $numero = 1; 
        if (isset($_POST["reseptit"])){
        for ($x = 0; $x < $montako; $x++) {
            $Paikka = $kaikki[$montako-$numero];
            $palaset = $Paikka; $palasina = explode(" ", $palaset);
        ?>
        <a href="/php/resepti.php?resepti=<?=$palasina[0]?>&tekija=<?=$palasina[1]?>"><?php echo $palasina[0]; $numero = $numero + 1;?></a>
        <?php }
        }?>
        </div>
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