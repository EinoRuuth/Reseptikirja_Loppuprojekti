<!DOCTYPE html>
<html>
<head>
    <style>
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
        input[type=text], select, textarea {
            width: 100%; 
            padding: 12px; 
            border: 1px solid #ccc; 
            border-radius: 4px; 
            box-sizing: border-box; 
            margin-top: 6px; 
            margin-bottom: 16px;
            resize: vertical
        }
        input[type=submit] {
            background-color: #04AA6D;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type=submit]:hover {
            background-color: #45a049;
        }
        .container {
            border-radius: 5px;
            background-color: #f2f2f2;
            padding: 20px;
        }
    </style>
</head>
<body>
    <?php session_start(); include 'dbCOnfig.php'; ?>
    <div class="topnav">
    <a href="/php/etusivu.php">Einon sopat</a>
    <a href="/php/reseptihaku.php">Reseptihaku</a>
    <?php if (isset($_SESSION["käyttäjänimi"])) { ?>
        <a href="?page=kirjoita">Kirjoita resepti</a>
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
            <?php if (isset($_SESSION["käyttäjänimi"])) { ?>
            <a class="active" href="/php/kirjoitapalaute.php">Lähetä Palautetta</a>
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
    <div class="container">
  <form method="post">
    <label for="Otsikko">Otsikko</label>
    <input type="text" id="otsikko" name="otsikko" placeholder="Palautteesi otsikko (Max. 500 kirjainta)" required>
    <label for="kuvaus">Kuvaus</label>
    <textarea id="kuvaus" name="kuvaus" placeholder="Kirjoita palaute (Max. 3000 kirjainta)" style="height:200px" required></textarea>
    <input type="submit" value="Submit">

  </form>
</div>
<?php
    if (isset($_POST["otsikko"])) {
        $header = str_replace("'", "''", $_POST["otsikko"]);
        $desc = str_replace("'", "''", $_POST["kuvaus"]);

        $addsql = "INSERT INTO palaute VALUES ('$header', '$desc')";
		$result = $conn->query($addsql);
        if ($result ===TRUE) {
            header("Location: /php/etusivu.php");
            exit();
		} else {
			echo "Virhe: ". $addsql. "<br>". $conn->error;
		}
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
<?php $conn->close(); ?>
</body>
</html>