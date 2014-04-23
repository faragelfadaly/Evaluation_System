<?php
session_start();
if (isset($_POST['chngepassword'])&& $_POST['oldpass'] && $_POST['newpass']) {

    if (isset($_SESSION['userid']) && isset($_SESSION['type'])) {
        
        include('config.php');
        $link = connectToDB();

        $userid = $_SESSION['userid'];
        $oldpass = $_POST['oldpass'];
        $newpass = $_POST['newpass'];

        if ($_SESSION['type'] == "admin") {
            if (!$result = mysqli_query($link, "UPDATE `admin` SET `password`='$newpass' WHERE `id`='$userid' and `password`='$oldpass'")) {
                die("Invalid admin password");
            } else {
                $affected = mysqli_affected_rows($link);
                if ($affected == 1) {
                    @header("Location: admin_files/adminpage.php");
                    exit();
                } else {
                    @header("Location: changepass.php");
                    exit();
                }
            }
        } else if ($_SESSION['type'] == "student") {
            if (!$result = mysqli_query($link, "UPDATE `student` SET `password`='$newpass' WHERE `id`='$userid' and `password`='$oldpass'")) {
                die("Invalid student password");
            } else {
                $affected = mysqli_affected_rows($link);
                if ($affected == 1) {
                    @header("Location: user_files/user-home.php");
                    exit();
                } else {
                    @header("Location: changepass.php");
                    exit();
                }
            }
        }
    }
}
?>
<html>

    <div id='2'align='center' style="margin-top: 150px">
        <form action='changepass.php' id='login' method='post' accept-charset='UTF-8'>
            
            <fieldset style="width: 350px; height: 300px ;font-size: 30px ">
                <a href="user_files/user-home.php" style="margin-left:7em ">main page</a>
                <br/>
                
                <input type='hidden' name='submitted' id='submitted' value='1'/>
                <br/>
                <label for='password' >Old Password:</label>
                <input type='password' name='oldpass' id='password' maxlength="50" />
                <br/><br/>
                <label for='password' >New Password:</label>
                <input type='password' name='newpass' id='password' maxlength="50" />
                <br/><br/>

                <input type='submit' name='chngepassword' value='Change Passwwrd' />

            </fieldset>
        </form>
    </div>
</html>

