<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            background-color: #90EE90;
        }
        .ylä, .valmis, .reseptinimi {
            text-align:center;
        }
        #nimiid {
            width: 20em;
            height: 2em;
            font-size:20px;
        }
        .ohje {
            width:50%;
            display:inline;
            float:left;
            font-size: 20px;
        }
        .aineet{
            width:50%;
            display:inline;
            float:left;
            font-size: 20px;
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
    include 'dbConfig.php';
    ?>
    <div class="topnav">
    <a href="/php/etusivu.php">Einon sopat</a>
    <a href="/php/reseptihaku.php">Reseptihaku</a>
    <?php if (isset($_SESSION["käyttäjänimi"])) { ?>
        <a class="active" href="/php/kirjoitaresepti.php">Kirjoita resepti</a>
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
    <div class="ylä">
        <h1>Reseptin kirjoitus</h1>
        <form action="upload.php" method="post" enctype="multipart/form-data">
        <label>Lisää kuva (nimeä kuva reseptin mukaan!)</label>
        <input type="file" name="file">
    </div>
    <br><br>
    <div class="reseptinimi">
        <input type="text" id="nimiid" name="reseptinimipost" placeholder="Anna reseptin nimi">
        <br><br>
        <label>Valitse ruokalaji</label>
        <br>
        <select name="ruokalaji">
                <option value="alkuruoka">Alkuruoka</option>
                <option value="pääruoka">Pääruoka</option>
                <option value="jälkiruoka">Jälkiruoka</option>
            </select>
    </div>
    <div class="aineet">
        <p>ainekset</p>
            <textarea name="ainekset" placeholder="Kirjoita reseptin ainekset tähän

Esim. Mansikka 5kpl
      Mustikka 5L" cols="50" rows="15" style="vertical-align:top"></textarea>
        
    </div>
    <div class="ohje">
        <p>valmistusohje</p>
        
        <textarea name="ohjeet" placeholder="Kirjoita reseptin ohjeet tähän." cols="50" rows="15" style="vertical-align:top"></textarea>
        
    </div>
    <div class="valmis">
        
            <input type="submit" name="valmis" value="Valmis" style="height:50px; width:100px;" />
        </form>
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