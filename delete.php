<?php 
    header("location: index.php");
    //connect to the database
    try {
        $db = new PDO('mysql:host=localhost;dbname=taskmanager','taskUser','!J(bcU.1_Gjv4BlR');
    } catch (PDOException $e) {
        echo 'Connection failed'. $e->getMessage();
    }

    if(isset($_GET['id'])){
    //Prepare the sql queries, get is used in order to obtain the id number.Is less secure this way,
    //but is the only way I found out.
    $oldID = $_GET['id'];
    $eraseID = $db->prepare("DELETE FROM task WHERE id = ?");
    $eraseID->execute([$oldID]);


    }

?>