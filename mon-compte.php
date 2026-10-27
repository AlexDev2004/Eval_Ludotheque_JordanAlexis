<?php include('utils/utils.php'); 
include('includes/header.php'); 

// Si l'utilisateur n'est pas connecté, rediriger vers la page de connection
if(!isset($_SESSION['id'])){
    header("Location:connection.php");
    exit;
}
$idUser = $_SESSION['id'];
try{
    $pdo = new PDO('mysql:host=localhost;dbname=ludotheque','root','root',[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $rUser=$pdo->prepare("SELECT m.prenom , m.nom , m.email , m.date_inscription FROM membre m WHERE m.id_membre = ?");
    $rUser->bindParam(1,$idUser,PDO::PARAM_INT);
    $rUser->execute();
    $user = $rUser->fetch(PDO::FETCH_ASSOC);
    $prenom = $user['prenom'];
    $nom = $user['nom'];
    $email = $user['email'];
    $date = date("d/m/Y à H:i",strtotime($user['date_inscription']));

    $rJeux=$pdo->prepare("SELECT j.titre FROM jeu j WHERE j.id_membre = ?");
    $rJeux->bindParam(1,$idUser,PDO::PARAM_INT);
    $rJeux->execute();
    $jeux = $rJeux->fetchAll(PDO::FETCH_ASSOC);
}catch(EXCEPTION $error){die($error->getMessage());}?>

<body>
    <section class="compte">
        <h1>Mon compte</h1>
        <p>Prenom : <?php echo($prenom) ?></p>
        <p>Nom : <?php echo($nom) ?></p>
        <p>Adresse E-mail : <?php echo($email) ?></p>
        <p>Inscrit le : <?php echo($date) ?></p>
    </section>
    <section class="compte">
        <h2>Liste de mes jeux :</h2>
        <ul>
            <?php
                foreach($jeux as $jeu){
                    echo("<li>$jeu[titre]</li>");
                }
            ?>
        </ul>
    </section>
</body>

<?php include('includes/footer.php') ?>
