<!DOCTYPE html>
<html>
<head>
    <title>Formulaire de Connexion</title>
</head>
<body>
    <h2>Connexion</h2>
    <form action="connexion.php" method="post">
        <label for="login">Nom d'utilisateur:</label>
        <input type="text" id="login" name="login" required>
        <br>
        <label for="mdp">Mot de passe:</label>
        <input type="password" id="mdp" name="mdp" required>
        <br>
        <input type="submit" value="Se connecter">
    </form>
</body>
</html>

