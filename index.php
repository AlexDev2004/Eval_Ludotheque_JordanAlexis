<?php include('utils/utils.php'); 
include('includes/header.php'); 
try{
    $pdo = new PDO('mysql:host=localhost;dbname=ludotheque','root','root',[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $rJeux=$pdo->prepare("SELECT j.id_jeu , j.titre , j.joueurs_min , j.joueurs_max , j.duree , c.nom_categorie , m.prenom 
        FROM jeu j JOIN categorie c ON j.id_categorie = c.id_categorie JOIN membre m ON m.id_membre = j.id_membre
            ORDER BY j.titre");
    $rJeux->execute();
    $jeux = $rJeux->fetchAll(PDO::FETCH_ASSOC);
}catch(EXCEPTION $error){die($error->getMessage());}
?>

<body>
    <section><?php
        foreach($jeux as $jeu){
            $formatJoueurs = formatJoueur($jeu['joueurs_min'] , $jeu['joueurs_max']);
            $formatDuree = categorieDuree($jeu['duree']);
            echo("<article>
                <h2>$jeu[titre]</h2>
                <p>$jeu[nom_categorie]</p>
                <p>$formatJoueurs</p>
                <p>$jeu[duree] - $formatDuree</p>
                <p>Ajouté par : $jeu[prenom]</p>
            </article>
        ");}
    ?></section>
</body>

<?php include('includes/footer.php') ?>

