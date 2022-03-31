<?php
require_once '_connec.php';
$pdo = new \PDO(DSN, USER, PASS);

if($_GET && !isset($_GET['form_success'])){
    if(isset($_GET['firstname']) && !empty($_GET['firstname']) && isset($_GET['lastname']) &&  !empty($_GET['lastname'])){

        $firstname = trim($_GET['firstname']); 
        $lastname = trim($_GET['lastname']);

        if(strlen($firstname) >= 45){ 
            $result_form .= "<br />Le champs PRENOM ne doit pas contenir plus de 45 caractères. Veuillez le vérifier."; 
        }

        if(strlen($lastname) >= 45){
            $result_form .= "<br />Le champs NOM ne doit pas contenir plus de 45 caractères. Veuillez le vérifier.";
        }

        $query = 'INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)';
        $statement = $pdo->prepare($query);

        $statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
        $statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);

        $statement->execute();

        header('Location: index.php?form_success');
    } else {
        $result_form = "Le formulaire comporte des erreurs : Tous les champs du formulaire sont obligatoires. Veuillez les vérifier.";
    }
}

if(isset($_GET['form_success'])){
    $result_form = "Formulaire envoyé avec succès";
}

$query = 'SELECT * FROM friend';
$statement = $pdo->query($query);
$friends = $statement->fetchAll(PDO::FETCH_OBJ);

foreach($friends as $friend){
    echo $friend->firstname." ". $friend->lastname;
    echo "<br /><hr /><br />";
}

echo (!empty($result_form)) ? $result_form : 'Veuillez remplir formulaire pour ajouter un ami <br /><br />';
?>

<form>
    <label for="firstname">FIRSTNAME</label>
    <input type="text" name="firstname" /><br /><br />
    <label for="lastname">LASTNAME</label>
    <input type="text" name="lastname" /><br /><br />
    <input type="submit" value="ENVOYER">
</form>