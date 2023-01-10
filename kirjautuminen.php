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
    if (isset($_GET["link"])) {
        header ("Location: /php/rekisterointi.php");
        exit();
    }
    include 'dbConfig.php';
        ?>
        <form action="kirjautuminen.php" method="post">
        <h2>kirjaudu</h2>
        <div class="container">
        <label><b>Käyttäjänimi</b></label>
        <input type="text" placeholder="käyttäjänimi" name="nimi" required>
        <br>
        <label><b>Salasana</b></label>
        <input type="password" placeholder="salasana" name="salasana" required>
        <br>
        <button type="submit" name="kirkirjattu">Kirjaudu</button>
        </div>
        </form>
        <div class="kirjautuminen">
            <br>
            <form action="kirjautuminen.php" method="post">
                <input type="submit" name="kirjaudu" value="Etusivulle">
                <a href="kirjautuminen.php?link">Rekisteröidy</a>
            </form>
        </div>
    <?php
    if (isset($_POST["nimi"])) {
        $username = $_POST["nimi"];
        $password = $_POST["salasana"];
        $sql = "SELECT * FROM käyttäjä WHERE käyttäjänimi LIKE '$username' AND salasana LIKE '$password'";
		$result = $conn->query($sql);
		if ($result->num_rows>0) {
			echo "Käyttäjä löytyy";
            while($row=$result->fetch_assoc()) {
                $id = $row["tunnus"];
            }
            $_SESSION["käyttäjänimi"] = $username;
            $_SESSION["id"] = $id;
            header("Location: /php/redirect.php");
            exit();
        } else {
            echo "käyttäjä tai salasana on väärin";
        }
    }
?>
<?php $conn->close(); ?>
</body>
</html>