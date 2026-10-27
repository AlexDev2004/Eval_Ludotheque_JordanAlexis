<?php session_start(); 

include('includes/header.php'); ?>

<body>
    <form action="#" method="post">
        <label for="prenom">Prénom</label>
        <input type="text" name="prenom" id="prenom" required>
        <label for="nom">Nom</label>
        <input type="text" name="nom" id="nom" required>
        <label for="email">Adresse E-mail</label>
        <input type="email" name="email" id="email" required>
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" required>
        <label for="password2">Confirmer le mot de passe</label>

        <input type="password" name="password2" id="password2" required>
        <button type="submit" name="inscription">Confirmer</button>
    </form>


    <?php 
        try{
            $pdo = new PDO('mysql:host=localhost;dbname=ludotheque','root','root',[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

            if(isset($_POST['inscription'])){
                if(!empty($_POST['prenom']) && !empty($_POST['nom']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password2'])){
                    if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && strlen($_POST['password']) >= 12){
                        $rCheckEmail = $pdo->prepare("SELECT m.id_membre FROM membre m WHERE m.email = ?");
                        $rCheckEmail->bindParam(1,$_POST['email'],PDO::PARAM_STR);
                        $rCheckEmail->execute();
                        $checkEmail = $rCheckEmail->fetch(PDO::FETCH_ASSOC);
                        if(!empty($checkEmail['id_membre'])) die("Adresse E-mail indisponible !");
                        if($_POST['password'] != $_POST['password2']) die("Les mots de passe ne correspondent pas !");

                        $email = trim($_POST['email']);
                        $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
                        $nom = $_POST['nom'];
                        $prenom = $_POST['prenom'];

                        $rNewMembre = $pdo->prepare("INSERT INTO membre (nom , prenom , email , mot_de_passe) VALUE (?,?,?,?)");
                        $rNewMembre->bindParam(1,$nom,PDO::PARAM_STR);
                        $rNewMembre->bindParam(2,$prenom,PDO::PARAM_STR);
                        $rNewMembre->bindParam(3,$email,PDO::PARAM_STR);
                        $rNewMembre->bindParam(4,$password,PDO::PARAM_STR);
                        $rNewMembre->execute();

                        echo("Membre $prenom $nom ajouté avec succés !");
                    }
                }
            }
        }catch(EXCEPTION $error){die($error->getMessage());}
    
    ?>
</body>


<?php include('includes/footer.php') ?>

