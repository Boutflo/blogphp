<?php



// var is_connectégale à faux
$is_connect = FALSE ;

 // si  var cookie sid définit et diff nul et var cookie sid différent de vide
 if (isset($_COOKIE['sid']) AND ! empty($_COOKIE['sid'])) {
     // requête contage id
    $count_sid = "SELECT COUNT(*) as nb_sid, "
                    . "nom,  "
                    . "prenom "
                    . "FROM utilisateurs "
                    . "WHERE sid = :sid" ;
    
    
       /* @var $bdd PDO */
        $sth = $bdd->prepare($count_sid);
        $sth->bindValue(':sid',$_COOKIE['sid'], PDO::PARAM_STR);
        // excécution requête
        $sth->execute();
        // mettre variable sth dans un tableau avec les champs
        $tab_result = $sth->fetch(PDO::FETCH_ASSOC);
       // afficher tableau
      //  print_r($tab_result) ;
        //comparer variable à un champ vide
         if ($tab_result['nb_sid'] > 0)  { 
            $is_connect = TRUE;
            $nom_connect = $tab_result['nom'] ;
            $prenom_connect = $tab_result['prenom'];
         }
 }