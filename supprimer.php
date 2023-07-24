<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "levenly";

// Vérifier si l'identifiant de l'article a été passé dans l'URL
if (isset($_GET["id"])) {
    $article_id = $_GET["id"];

    // Créer une connexion à la base de données
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if (!$conn) {
        die("La connexion à la base de données a échoué: " . mysqli_connect_error());
    }

    // Supprimer l'article de la base de données
    $sql = "DELETE FROM articles WHERE id = $article_id";
    if (mysqli_query($conn, $sql)) {
    // Fermer la connexion
    mysqli_close($conn);
    echo '<meta charset="utf-8">
            <script type="text/javascript">
            alert("Suppression validée.");
            window.location.href = "menu.php";
          </script>';
    exit();
    } else {
        echo "Erreur lors de la suppression de l'article : " . mysqli_error($conn);
    }

    // Fermer la connexion
    mysqli_close($conn);
}
?>
