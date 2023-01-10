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
    </style>
</head>
<body>
    <?php session_start();
    include 'dbConfig.php'; ?>
   <div class="topnav">
    <a class="active" href="/php/etusivu.php">Einon sopat</a>
    <a href="/php/reseptihaku.php">Reseptihaku</a>
    <?php if (isset($_SESSION["käyttäjänimi"])) { ?>
        <a href="/php/kirjoitaresepti.php">Kirjoita resepti</a>
    <?php } ?>
    <?php if (isset($_SESSION["id"])) {
            if ($_SESSION["id"] == "4704413142") { ?>
            <a href="/php/palautteet.php">Lue palateet</a>
        <?php } } ?>
    <?php if (isset($_SESSION["käyttäjänimi"])) { $username = $_SESSION["käyttäjänimi"] ?>
    <div class="dropdown">
        <button class="dropbtn"><?php echo $username; ?>
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content">
            <a href="#">Oma profiili</a>
            <?php if (isset($_SESSION["käyttäjänimi"])) { ?>
            <a href="?page=uloskirjaudu">Kirjaudu ulos</a>
            <?php } ?>
            <?php if (isset($_SESSION["käyttäjänimi"])) { ?>
            <a href="/php/kirjoitapalaute.php">Lähetä Palautetta</a>
            <?php } ?> 
            <?php if (isset($_SESSION["id"])) {
            if ($_SESSION["id"] == "4704413142") { ?>
            <a class="active" href="/php/redirect.php">Ylläpitäjä</a>
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
    if (isset($_POST["kirjaudu"])) {
        header("Location: /php/etusivu.php");
        exit();
    }
    if (isset($_SESSION["poistaid"])) {
        $id = $_SESSION["poistaid"];
        $removesql = "DELETE FROM resepti WHERE reseptiid=$id";
        if ($conn->query($removesql) === TRUE) {
            echo "Resepti on poistettu";
        } else {
            echo "Virhe: " . $conn->error;
        }
        $conn->close();
    }
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