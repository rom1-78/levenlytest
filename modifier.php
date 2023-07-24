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

    // Vérifier si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupérer les données du formulaire
        $nom_article = $_POST["nom_article"];
        $prix = $_POST["prix"];
        $contenu = $_POST["contenu"];

        // Éviter les injections SQL en utilisant les requêtes préparées
        $stmt = mysqli_prepare($conn, "UPDATE articles SET nom_article=?, prix=?, contenu=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "sdsi", $nom_article, $prix, $contenu, $article_id);

        // Exécuter la requête préparée
        if (mysqli_stmt_execute($stmt)) {
        // Fermer la connexion
        mysqli_close($conn);
        echo '<meta charset="utf-8">
            <script type="text/javascript">
                alert("Modification effectuée avec succès.");
                window.location.href = "menu.php";
              </script>';
        exit();
        } else {
            echo "Erreur lors de la mise à jour de l'article : " . mysqli_error($conn);
        }

        // Fermer la connexion
        mysqli_close($conn);
    } else {
        // Récupérer les informations de l'article à partir de la base de données
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        $sql = "SELECT * FROM articles WHERE id = $article_id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        mysqli_close($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier un Article</title>
</head>
<body>
    <?php if (isset($row)) { ?>
    <h2>Modifier l'Article</h2>
    <form action="modifier.php?id=<?php echo $article_id; ?>" method="post">
        <label for="nom_article">Nom de l'article:</label>
        <input type="text" id="nom_article" name="nom_article" value="<?php echo $row['nom_article']; ?>" required>
        <br>
        <label for="prix">Prix:</label>
        <input type="number" id="prix" name="prix" step="0.01" value="<?php echo $row['prix']; ?>" required>
        <br>
        <label for="contenu">Contenu:</label>
        <textarea id="contenu" name="contenu" rows="4" cols="50" required><?php echo $row['contenu']; ?></textarea>
        <br>
        <input type="submit" value="Modifier l'article">
    </form>
    <?php } else { ?>
    <p>L'article n'existe pas.</p>
    <?php } ?>
</body>
</html>
