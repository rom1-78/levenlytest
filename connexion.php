<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "levenly";

// Créer une connexion à la base de données
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Vérifier la connexion
if (!$conn) {
    die("La connexion à la base de données a échoué: " . mysqli_connect_error());
}

$login = $_POST["login"];
$mdp = $_POST["mdp"];

// Éviter les injections SQL en utilisant les requêtes préparées (recommandé)
$stmt = mysqli_prepare($conn, "SELECT * FROM connexion WHERE login=? AND mdp=?");
mysqli_stmt_bind_param($stmt, "ss", $login, $mdp);
mysqli_stmt_execute($stmt);
$resultat = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($resultat) == 1) {
    header("Location:menu.php");
    exit();
} else {
    ?>
    <script type="text/javascript">
        alert("L'identifiant ou le mot de passe est incorrecte");
        history.back();
    </script>
    <?php
}

// Fermer la connexion
mysqli_close($conn);
?>
