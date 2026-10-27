<?php include('utils/utils.php'); 
include('includes/header.php'); 

// Si l'utilisateur n'est pas connecté, rediriger vers la page de connection
if(!isset($_SESSION['id'])){
    header("Location:connection.php");
    exit;
}
// -------------------------------------------------------------------------

// Récupérer la liste des categories
try{
    $pdo = new PDO('mysql:host=localhost;dbname=ludotheque','root','root',[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $rCategories=$pdo->prepare("SELECT c.nom_categorie , c.id_categorie FROM categorie c");
    $rCategories->execute();
    $categories = $rCategories->fetchAll(PDO::FETCH_ASSOC);
}catch(EXCEPTION $error){die($error->getMessage());}
// ---------------------------------
?>

<body>
    <form action="#" method="post">
        <label for="titre">Titre</label>
        <input type="text" name="titre" id="titre" required>
        <label for="min">Nombre minimum de joueurs</label>
        <input type="number" name="min" id="min" required>
        <label for="max">Nombre maximum de joueurs</label>
        <input type="number" name="max" id="max" required>
        <label for="duree">Durée d'une partie (en minutes)</label>
        <input type="number" name="duree" id="duree" required>
        <label for="categorie">Catégories</label>
        <select name="categorie" id="categorie">
            <?php foreach($categories as $categorie){
                echo("<option value='$categorie[id_categorie]'>$categorie[nom_categorie]</option>");
            }?>
        </select>
        <button type="submit" name="nouveauJeu">Confirmer</button>
    </form>


<?php
try{
    $pdo = new PDO('mysql:host=localhost;dbname=ludotheque','root','root',[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    // Je récupère les données saisies par l'utilisateur et vérifie leur contenu
    if(isset($_POST['nouveauJeu'])){
        if(!empty($_POST['titre']) && !empty($_POST['min']) && !empty($_POST['max']) && !empty($_POST['duree']) && !empty($_POST['categorie'])){
            if(filter_var($_POST['min'], FILTER_VALIDATE_INT) && filter_var($_POST['max'], FILTER_VALIDATE_INT) && filter_var($_POST['duree'], FILTER_VALIDATE_INT) && filter_var($_POST['categorie'], FILTER_VALIDATE_INT)){
                if($_POST['min'] >= 1 && $_POST['max'] >= $_POST['min'] && $_POST['duree'] > 0){
                    $titre = trim($_POST['titre']);
                    $min = trim($_POST['min']);
                    $max = trim($_POST['max']);
                    $duree = trim($_POST['duree']);
                    $categorie = trim($_POST['categorie']);
                    $idJoueur = $_SESSION['id'];

                    $rCheckGame=$pdo->prepare("SELECT j.titre FROM jeu j WHERE j.titre = ?");
                    $rCheckGame->bindParam(1,$titre,PDO::PARAM_STR);
                    $rCheckGame->execute();
                    $game = $rCheckGame->fetch(PDO::FETCH_ASSOC);

                    if(!empty($game)) die("Ce jeu existe déjà !");

                    // BONUS : Vérifier que la catégorie existe :
                    $rCheckCategorie=$pdo->prepare("SELECT c.id_categorie FROM categorie WHERE c.id_categorie = ?");
                    $rCheckCategorie->bindParam(1,$categorie,PDO::PARAM_INT);
                    $rCheckCategorie->execute();
                    $checkCategorie = $rCheckCategorie->fetch(PDO::FETCH_ASSOC);

                    if(empty($checkCategorie)) die("La catégorie sélectionée n'existe pas !");
                    // -----------------------------------------

                    // Une fois les vérifications passées, j'entre le nouveau jeu en base de donnée
                    $rNouveauJeu=$pdo->prepare("INSERT INTO jeu (titre , joueurs_min , joueurs_max , duree , id_categorie , id_membre) VALUE (?,?,?,?,?,?)");
                    $rNouveauJeu->bindParam(1,$titre,PDO::PARAM_STR); 
                    $rNouveauJeu->bindParam(2,$min,PDO::PARAM_STR); 
                    $rNouveauJeu->bindParam(3,$max,PDO::PARAM_STR); 
                    $rNouveauJeu->bindParam(4,$duree,PDO::PARAM_STR); 
                    $rNouveauJeu->bindParam(5,$categorie,PDO::PARAM_STR); 
                    $rNouveauJeu->bindParam(6,$idJoueur,PDO::PARAM_STR); 
                    $rNouveauJeu->execute();

                    echo("Le jeu $titre à bien été ajouté !");
                }else{die("Les valeurs sont invalides !");}
            }else{die("Les valeurs sont invalides !");}
        }else{die("Veuillez remplir tous les champs !");}
    }
}catch(EXCEPTION $error){die($error->getMessage());}

?>

</body>