<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "levenly";

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom_article = $_POST["nom_article"];
    $prix = $_POST["prix"];
    $contenu = $_POST["contenu"];

    // Créer une connexion à la base de données
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if (!$conn) {
        die("La connexion à la base de données a échoué: " . mysqli_connect_error());
    }

    // Éviter les injections SQL en utilisant les requêtes préparées
    $stmt = mysqli_prepare($conn, "INSERT INTO articles (nom_article, prix, contenu) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sds", $nom_article, $prix, $contenu);

    // Exécuter la requête préparée
    if (mysqli_stmt_execute($stmt)) {
        // Fermer la connexion
        mysqli_close($conn);

        // Afficher une alerte en JavaScript
        echo '<meta charset="utf-8">
        <script type="text/javascript">
                alert("Article ajouté avec succès.");
                window.location.href = "menu.php";
              </script>';
    } else {
        echo "Erreur lors de l'ajout de l'article : " . mysqli_error($conn);
    }

    // Fermer la connexion
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un Article</title>
</head>
<body>
    <h2>Ajouter un Article</h2>
    <form action="ajouter_article.php" method="post">
        <label for="nom_article">Nom de l'article:</label>
        <input type="text" id="nom_article" name="nom_article" required>
        <br>
        <label for="prix">Prix:</label>
        <input type="number" id="prix" name="prix" step="0.01" required>
        <br>
        <label for="contenu">Contenu:</label>
        <textarea id="contenu" name="contenu" rows="4" cols="50" required></textarea>
        <br>
        <input type="submit" value="Ajouter l'article">
    </form>
</body>
</html>
