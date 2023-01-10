<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            background-color: #90EE90;
            margin-left: 500px;
        }
        form {
        border: 3px solid #f1f1f1;
        max-width: 250px;
        text-align:center;
        background-color:white;
        }

        input[type=text], input[type=password] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
        }

        button {
        background-color: #04AA6D;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        }

        button:hover {
        opacity: 0.8;
        }
    </style>
</head>
<body>
<?php
    session_start();
    if (isset($_POST["kirjaudu"])) {
        header("Location: /php/etusivu.php");
        exit();
    }
    if (isset($_GET["link1"])) {
        header("Location: /php/kirjautuminen.php");
        exit();
    }
    include 'dbConfig.php';
    ?>
    <form action="rekisterointi.php" method="post">
    <div class="container">
    <h2>rekisteröidy</h2>
    <label><b>Käyttäjänimi</b></label>
    <input type="text" placeholder="käyttäjänimi" name="reknimi" required>
    <br>
    <label><b>Salasana</b></label>
    <input type="password" placeholder="salasana" name="salasana" required>
    <br>
    <button type="submit" name="kirkirjattu">Rekisteröidy</button>
    </div>
    </form>
    <?php
    if (isset($_POST["reknimi"])){
        $user = $_POST["reknimi"];
        $password = $_POST["salasana"];
        $id = rand(1000000000, 9999999999);
        $addsql = "INSERT INTO käyttäjä  VALUES ('$id', '$paddword', '$user')";
		$result = $conn->query($addsql);
        if ($tulos ===TRUE) {
			echo "Tuote lisätty";
            $_SESSION["käyttäjänimi"] = $user;
            $_SESSION["salasana"] = $password;
            header("Location: /php/redirect.php");
            exit();
		} else {
			echo "Virhe: ". $addsql. "<br>". $conn->error;
		}
    }
    ?>
    <div class="kirjautuminen">
        <br>
        <form action="rekisterointi.php" method="post">
            <input type="submit" name="kirjaudu" value="Etusivulle">
            <a href="rekisterointi.php?link1">Kirjaudu</a>
        </form>
    </div>
    <?php
    $conn->close();
?>
</body>
</html>