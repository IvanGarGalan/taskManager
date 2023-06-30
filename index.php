<?php 
    // initialize the errorID,errorTask,errorDate value 
    $errorTask = "";
    $errorDate = "";
    $errorID = "";
    //connect to the database
    try {
        $db = new PDO('mysql:host=localhost;dbname=taskmanager','taskUser','!J(bcU.1_Gjv4BlR');
    } catch (PDOException $e) {
        echo 'Connection failed'. $e->getMessage();
    }

    //insert a quote when the submit button is clicked
    if (isset($_POST['submit'])) {
        if (empty($_POST['task'])) {
            $errorTask = "You must fill in the task";
        }
        if (empty($_POST['date'])) {
            $errorDate = "You must fill in the date";     
        }
        if (empty($_POST['id'])) {
            $errorID = "You must fill in the id";
        }
        else{
            $id = $_POST['id'];
            $task = $_POST['task'];
            $date = $_POST['date'];
            //Start the transacction in order to execute the sql queries
            $db->beginTransaction();
            //Declare the sql query
            $success = $db->prepare("INSERT INTO task(id,task,date) VALUES (?,?,?)");
            //The values are here in order to avoid SQL injections.
            $success->execute([$id,$task,$date]);
            //Commit
            $db->commit();
            //If statement for seeing a success
            if ($success) {
                echo "Successful statement";
            }else{
                echo "An error has occurred.Try again later";
                //If nothing gets added, the database does a rollback
                $db->rollBack();
            }
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>Task manager</title>
</head>
<body>
    <!-- Header  -->
    <header class="header">
        <h1 class="title">Task manager</h1>
    </header>
    <!-- Main -->
    <main class="main">
        <form method="post" action="index.php" class="form">
            <!--PHP code for inserting an empty ID -->
            <?php if (isset($errorID)) { ?>
	            <p><?php echo $errorID; ?></p>
            <?php } ?>
            <!-- Adding a name for the ID -->
        <label for="id">ID</label>
        <input type="number" name="id">

            <!-- PHP code for inserting an empty task  -->
            <?php if (isset($errorTask)) { ?>
	            <p><?php echo $errorTask; ?></p>
            <?php } ?>
            <!-- Adding a name for the task -->
        <label for="title">Name</label>
        <input type="text" name="task">

            <!--PHP code for inserting an empty date  -->
            <?php if (isset($errorDate)) { ?>
                <p><?php echo $errorDate; ?></p>
            <?php } ?>
        <!-- Adding a date for the task -->
        <label for="date">Date</label>
        <input type="date" name="date">
        <!-- Submitting the task to the database -->
        <button type="submit" name="submit" id="add_btn">Add task</button>


        </form>
    </main>
</body>
</html>