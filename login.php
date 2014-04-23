<?php
include('config.php');
session_start();
// Signout
if (isset($_GET['value'])) {

    session_unset();
    setcookie("cookie[0]", "", time() - 3600);
    setcookie("cookie[1]", "", time() - 3600);

    @header("Location: index.php");
    exit;
}

if (isset($_COOKIE['cookie'])) {
    $_SESSION['type'] = $_COOKIE['cookie'][0];
    $_SESSION['userid'] = $_COOKIE['cookie'][1];
}

if (isset($_SESSION['userid']) && isset($_SESSION['type'])) {

    if ($_SESSION['type'] == "admin") {
        @header("Location: admin_files/adminpage.php");
    } else if ($_SESSION['type'] == "student") {
        @header("Location: user_files/user-home.php");
    }
    exit;
} else {
    if (isset($_POST['username']) && isset($_POST['password']) && $_POST['username'] && $_POST['password']) {

        $link = connectToDB();

        $username = $_POST['username'];
        $password = $_POST['password'];
        $userid = 0;

        if (!$result = mysqli_query($link, "SELECT  `id` 
                                        FROM  `admin` 
                                        WHERE  `username` LIKE  '$username'
                                        AND  `password` Like  '$password'")) {
            die("Invalid admin login");
        } else {
            $affected = mysqli_affected_rows($link);
            if ($affected == 1) {

                if ($row = mysqli_fetch_assoc($result)) {

                    $userid = $row['id'];
                }
                if ($_POST['save'] == yes) {

                    setcookie("cookie[0]", "admin", time() + 30 * 24 * 60 * 60);
                    setcookie("cookie[1]", $userid, time() + 30 * 24 * 60 * 60);
                }

                $_SESSION['type'] = "admin";
                $_SESSION['userid'] = $userid;
                if (isset($_POST['login'])) {

                    @header("Location: admin_files/adminpage.php");

                    exit();
                } else {
                    @header("Location: changepass.php");

                    exit();
                }
            } else if (!$result = mysqli_query($link, "SELECT `id`  
                                        FROM  `student` 
                                        WHERE  `username` LIKE  '$username'
                                        AND  `password` Like  '$password'")) {
                die("Invalid student login");
            } else {

                $affected = mysqli_affected_rows($link);
                if ($affected == 1) {
                    $intake_id = 0;
                    if ($row = mysqli_fetch_assoc($result)) {

                        $userid = $row['id'];
                    }
                    if ($_POST['save'] == yes) {
                        setcookie("cookie[0]", "student", time() + 30 * 24 * 60 * 60);
                        setcookie("cookie[1]", $userid, time() + 30 * 24 * 60 * 60);
                    }
                    $_SESSION['type'] = "student";
                    $_SESSION['userid'] = $userid;

                    if (isset($_POST['login'])) {
                        @header("Location: user_files/user-home.php");
                        //var_dump($_SESSION);
                        exit();
                    } else {
                        @header("Location: changepass.php");
                        exit();
                    }
                } else {
                    @header("Location: index.php");
                }
            }
        }
    } else {
        ?>

        <html>           
            <head>
                <link type="text/css" rel="stylesheet" href="styles/jquery-ui-1.10.0.custom.css"/>
                <script  type="text/javascript" src="styles/jquery-1.8.0.js"></script>
                <script type="text/javascript" src="styles/jquery-ui-1.10.0.custom.js"></script>
                <script>
                    $(document).ready(function() {
                        $("#login").dialog({
                            width: 330,
                            height: 300,                            
                            closeText: 'Back to Index page',
                            beforeClose: function(event, ui) { 
                            $(this).dialog( "option", "hide", { effect: 'drop', direction: "down" } );                                
                            window.location.assign("index.php")
                        }
                        });
                    });

                </script>
            </head>
            <body>
                <div id="login" style="display: none; width: 300px; height: 300px;">
                    <form action='login.php' id='login' method='post' accept-charset='UTF-8'>                    
                        <br>
                        <input type='hidden' name='submitted' value='1'/>
                        <br>
                        <label for='username' style="color: #0070a3">Name:</label>
                        <input type='text' name='username' maxlength="50" />
                        <br><br>
                        <label for='password' style="color: #0070a3">Password:</label>
                        <input type='password' name='password' maxlength="50" />
                        <br><br>&nbsp;&nbsp;&nbsp;
                        <input type="checkbox" name="save" value="yes"/>
                        <label for='password' style="color: #0070a3">Save Password</label>                        
                        <br>
                        <input type='submit' name='login' value='Login' style="color: #0070a3"/>
                        <input type='submit' name='chngepassword' value='Change Password'  style="color: #0070a3"/>                   
                    </form>
                </div>           
        </body>
        </html>
        <?php
    }
}
?>
