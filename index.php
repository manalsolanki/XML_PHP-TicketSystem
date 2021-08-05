<?php
// Checks if file exist or not.


    //Loading XML file.
    $xml = simplexml_load_file("xml/user.xml");

    //Checks whether user has inputted the data.
    if(isset($_POST['login']))
    {
        $inputtedUserName = $_POST['userName'];
        $inputtedPassword = $_POST['password'];
        //Starting the session.
        session_start();

        //Loop through each element of xml file.
        foreach ($xml->children() as $u)
        {

            //Checking if username and password matches with the given password.
            if($inputtedUserName == $u->userName && $inputtedPassword == $u->password){

                //Storing username and id as session variable.
                $_SESSION['username'] = $inputtedUserName;
                $_SESSION['userid'] = $u->attributes()['id']."";
                $userRole = $u->attributes()['role']."";
                $_SESSION['userrole']=$userRole;
                // Redirecting according to role.
                if($userRole == "Support Staff")
                {
                    header('Location: admin.php');
                }
                else
                {
                    header ('Location:user.php');
                }

            }
            else
            {
                $errorMsg = "Please enter valid user name and password.";
            }

        }

}

?>
<html lang="en">
    <head>
        <title>Ticket System</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">    </head>
        <link rel="stylesheet" href="./css/style.css"/>
    <body>
    <?php include_once "header.php"; ?>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <form class="box" method="post">
                            <h1>Login</h1>
                            <p class="text-muted"> Please enter your User name and password!</p>
                            <div>
                                <label  for="userName">User Name</label>
                                <input type="text" name="userName" placeholder="Username" value="<?= isset($inputtedUserName)?$inputtedUserName:""; ?>">
                            </div>
                            <div>
                                <label for="Password">Password</label>
                                <input type="password" name="password" placeholder="Password" value="<?= isset($inputtedPassword)?$inputtedPassword:""; ?>">
                            </div>
                            <p class="text-danger"><?=  isset($errorMsg)?$errorMsg:""; ?></p>
                            <a class="forgot text-muted d-none" href="#">Forgot password?</a>
                            <input type="submit" name="login" value="Login">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include_once "bootstrapjs.php" ?>
    <body>
</html>
