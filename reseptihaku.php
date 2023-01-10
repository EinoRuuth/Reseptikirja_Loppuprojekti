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
        $all = array();
        if (isset($_POST["reseptit"])) {
            if (isset($_POST["reseptiname"])) {
                $name = $_POST["reseptiname"];
                $sql = "SELECT * FROM resepti WHERE nimi LIKE '%$nimi%'";
            }
            if (isset($_POST["ainesnimi"])) {
                $ingredient = $_POST["ainesnimi"];
                $sql = "SELECT * FROM resepti WHERE ainekset LIKE '%$aines%'";
            }
            if (isset($_POST["lajiname"])) {
                $course = $_POST["lajiname"];
                $sql = "SELECT * FROM resepti WHERE ruokalaji LIKE '%$laji%'";
            }
		    $results = $conn->query($sql);
		    if ($results->num_rows>0) {
                while($row=$results->fetch_assoc()) {
                    $searchname = $row["nimi"];
                    $creator = $row["kirjoittaja"];
                    $array = $searchname . ' ' . $creator;
                    $all[] = $array;
            }
            foreach ($all as $value) {
            }
            $howmany = count($all);

            } else {
                $howmany = 0;
            }
        }
    ?>
    <div class="topnav">
    <a href="/php/etusivu.php">Einon sopat</a>
    <a class="active" href="/php/reseptihaku.php">Reseptihaku</a>
    <?php if (isset($_SESSION["käyttäjänimi"])) { ?>
        <a href="/php/kirjoitaresepti.php">Kirjoita resepti</a>
    <?php } ?>
    <?php if (isset($_SESSION["käyttäjänimi"])) { $username = $_SESSION["käyttäjänimi"] ?>
    <div class="dropdown">
        <button class="dropbtn"><?php echo $username; ?>
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
        <?php $number = 1; 
        if (isset($_POST["reseptit"])){
        for ($x = 0; $x < $howmany; $x++) {
            $spot = $all[$howmany-$number];
            $pieces = $spot; $inpieces = explode(" ", $pieces);
        ?>
        <a href="/php/resepti.php?resepti=<?=$inpieces[0]?>&tekija=<?=$inpieces[1]?>"><?php echo $inpieces[0]; $number = $number + 1;?></a>
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