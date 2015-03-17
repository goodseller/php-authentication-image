<!--
A demo to get data from authPic.php for a form.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Form</title>
    </head>
    <body>
        <?php
        if(isset($_GET["authKey"])){
            echo "GET:\n";
            var_dump($_GET);
            session_start();
            echo "SESSION - authKey:\n";
            var_dump($_SESSION["authKey"]);
            if($_SESSION["authKey"] == $_GET["authKey"]){
                echo "Key match!";
            }else{
                echo "Key does not match.";
            };
            die(); 
        }
        ?>
        <h1>Form</h1>
        
        <form name="form" action="form.php">
            <input type="text" name="msg" value="Hello World!" /><br />
            <input type="text" name="authKey" value=""  />
            <img src="authPic.php" onclick="this.src='authPic.php?id='+Math.random() //live update cheats"/><br />
            <input type="submit" value="Submit" name="submit" />
        </form>
    </body>
</html>