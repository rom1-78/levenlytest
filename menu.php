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

mysqli_query($conn, "SET NAMES 'utf8'");

// Fonction pour exécuter une requête SQL
function executeQuery($conn, $sql) {
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die("Erreur dans la requête: " . mysqli_error($conn));
    }
    return $result;
}

// Fonction pour afficher la liste des articles
function afficherArticles($conn) {
    $sql = "SELECT * FROM articles";
    $result = executeQuery($conn, $sql);

    echo "<h2>Liste des Articles</h2>";
    echo "<ul>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<li>" . $row["nom_article"] . " - <a href='modifier.php?id=" . $row["id"] . "'>Modifier</a> - <a href='supprimer.php?id=" . $row["id"] . "'>Supprimer</a></li>";
    }
    echo "</ul>";
}

// Rechercher des articles par nom
if (isset($_GET["recherche"])) {
    $recherche = $_GET["recherche"];
    $sql = "SELECT * FROM articles WHERE nom_article LIKE '%$recherche%'";
    $result = executeQuery($conn, $sql);
    echo "<h2>Résultats de la Recherche</h2>";
    if (mysqli_num_rows($result) > 0) {
        echo "<ul>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<li>" . $row["nom_article"] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "Aucun résultat trouvé.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Menu</title>
    <meta charset="utf-8">
</head>
<body>
    <h1>Menu</h1>
    <a href="ajouter_article.php">Ajouter un nouvel article</a>
    <br>
    <h2>Rechercher un Article</h2>
    <form action="menu.php" method="get">
        <input type="text" name="recherche" placeholder="Nom de l'article" required>
        <input type="submit" value="Rechercher">
    </form>
    <?php
    // Afficher la liste des articles
    afficherArticles($conn);
    ?>
</body>
</html>
