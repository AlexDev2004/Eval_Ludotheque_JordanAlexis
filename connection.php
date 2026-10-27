<?php session_start(); 

include('includes/header.php'); ?>

<body>
    <form action="#" method="post">
        <label for="email">Adresse E-mail</label>
        <input type="email" name="email" id="email">
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password">
        <button type="submit" name="connection">Confirmer</button>
    </form>

    <?php
        try{
           $pdo = new PDO('mysql:host=localhost;dbname=ludotheque','root','root',[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
           $email = $_POST['email'];
           $password = $_POST['password'];
           $rConnect=$pdo->prepare("SELECT m.nom , m.prenom , m.email , m.id_membre , m.mot_de_passe FROM membre m WHERE m.email = ?");
           $rConnect->bindParam(1,$email,PDO::PARAM_STR);
           $rConnect->execute();
           $userConnect = $rConnect->fetch(PDO::FETCH_ASSOC);

           if(empty($userConnect['email'])) die("L'adresse E-mail ou le mot de passe est invalide !");
           if(!password_verify($password , $userConnect['mot_de_passe'])) die("L'adresse E-mail ou le mot de passe est invalide !");

           $_SESSION['id'] = $userConnect['id_membre'];
           $_SESSION['nom'] = $userConnect['nom'];
           $_SESSION['prenom'] = $userConnect['prenom'];
           $_SESSION['email'] = $userConnect['email'];

           header("Location:index.php");
           exit;
        }catch(EXCEPTION $error){ die($error->getMessage());}
    ?>
</body>
<?php include('includes/footer.php') ?>

