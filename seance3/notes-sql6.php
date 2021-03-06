<?php include 'connection.php';
// Connexion à la bdd
$db_server = "127.0.0.1";
$db_username = "root";
$db_pwd = "";
$db_name = "bdd_oussama_3ib";
$cnx = new PDO("mysql: host=$db_server; dbname=$db_name", $db_username, $db_pwd);
// Vérifier si le formulaire a été envoyé
if(isset($_POST['save']))
{
 // Récupérer le nom de l'étudiant
 $nom = $_POST['nom'];
 // Récupérer la note de l'étudiant
 $note = $_POST['note'];
 // Processus de sauvegarde dans la bdd en DEUX étapes :
 // 1 . Préparer la requête SQL
 $sql_note = "INSERT INTO notes(id, nom, note) VALUES(NULL,'$nom','$note')";
 // 2. Exécuter la requête SQL
 $cnx->exec($sql_note);
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Moyennes</title>
</head>
<body>
<h1>Saisir une moyenne</h1>
<form action="" method="post">
Nom de l'étudiant : <input type="text" name="nom"
required="required"> <br>
Sa moyenne : <input type="number" name="note" step="any"
required="required"><br>
<input type="submit" value="Sauvegarder" name="save">
</form>
<hr/>
<h1>Les notes saisies</h1>
Ci-dessous la liste des notes que vous avez saisies : <br/>
<?php
 // Récupérer les notes depuis la BdD :
 // 1. Préparer la requête
 $sql_notes = "SELECT * from notes";
 // 2. Lancer la requête
 $res_notes = $cnx->query($sql_notes);
 // Extraire (fetch) toutes les lignes (enregistrement, rows)
 $les_notes = $res_notes->fetchAll(); // Ceci est un tableau de tableaux associatifs
 // Calculer le nombre d'étudiants
 $nbr_etudiants = count($les_notes);

 if(!$nbr_etudiants ){
 // Afficher un message si la liste est vide
 echo "<b>Aucune note pour le moment !</b>";
 }
else
{
 // Afficher la liste des étudiant/note sous forme de liste ordonnée
 echo "Il y a $nbr_etudiants étudiants ";
 echo "<ol>";
foreach ($les_notes as $item) {
//echo "<li>" . $item['nom'] . " : " . $item['note'];
echo "<li>" . $item['nom'] . " : " . $item['note'] .
 " | <a href='supp-sql.php?id=" . $item['id'] . "'>
 Supprimer
 </a><a href='modif-sql.php?id=" . $item['id'] . "'>
 Modifier
 </a>";

}
echo "</ol>";
}
?>
</body>
</html>