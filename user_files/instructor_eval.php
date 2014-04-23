<?php
session_start();
include '../config.php';
$student_id = $_SESSION['userid'];

if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];
    $instructor_id = $_GET['instructor_id'];
}

if (isset($_POST['submit'])) {
    if (isset($_POST['ev1']) && isset($_POST['ev2']) && isset($_POST['ev3']) && isset($_POST['ev4']) && isset($_POST['ev5'])) {

        $link = connectToDB();

        $ev1 = $_POST['ev1'];
        $ev2 = $_POST['ev2'];
        $ev3 = $_POST['ev3'];
        $ev4 = $_POST['ev4'];
        $ev5 = $_POST['ev5'];

        $course_id = $_POST['course_id'];
        $instructor_id = $_POST['instructor_id'];

        $link = connectToDB();
        if (!$link) {
            die("connection Error");
        }


        $evaluation_query = executeQuery("
                INSERT INTO instructor_eval 
                        VALUES (
                        '$student_id',(select id from eval_inst_evtable where eval_id=(select id from evaluation where track_id=(select track_id from student where id='$student_id') and course_id='$course_id' ) and inst_id='$instructor_id'), '$ev1', '$ev2', '$ev3', '$ev4', '$ev5', '{$_POST['comment']}', '0'
                        );
                    ");

        if (!$evaluation_query) {
            die("Query Error");
        }
        header("Location: user-home.php");
    }
}
?>

<html>
    <head>
        <script src="../styles/jquery-1.8.0.js">                
            $("#com").click(function fnn() {
                ;
                $("#textarea").show();
            });

        </script>
        <style>
            td
            {
                color: darkcyan;
                font-weight: bold;
            }
        </style>
    </head>
    <div id='4' align='center' style="margin-top: 60px">

        <a href="../index.php?value=Signout">Signout</a>
        <form action='instructor_eval.php' id='login' method='post' accept-charset='UTF-8'>
            <fieldset style="width: 800px; height: 500px; background:#f6a828 ;color: darkcyan;font-size: 30px ">
                Instructor Evaluation
                <br>

                <br>
                <?php
                    $items = simplexml_load_file("../instevalitems.xml");
                    $dom = dom_import_simplexml($items)->ownerDocument;
                    $dom->formatOutput = true;
                ?>
                <table style="color: snow;font-size: 20px">
                    <tr style=" text-align: center">  <td style="width: 500px"> </td>
                        <td style="width: 20px;"> 1 
                        </td>  <td style="width: 20px;"> 2  
                        </td>  <td style="width: 20px"> 3   
                        </td>  <td style="width: 20px"> 4   
                        </td>  <td style="width: 20px"> 5   
                        </td> </tr>
                    <tr>  
                        <td name="ev1">*<?php echo $items->ArrayOfItems->string[0]->i; ?></td>
                        <td> <INPUT TYPE="RADIO" NAME="ev1" VALUE="1"> </td>  
                        <td> <INPUT TYPE="RADIO" NAME="ev1" VALUE="2"></td> 
                        <td> <INPUT TYPE="RADIO" NAME="ev1" VALUE="3"></td>  
                        <td> <INPUT TYPE="RADIO" NAME="ev1" VALUE="4"></td>
                        <td> <INPUT TYPE="RADIO" NAME="ev1" VALUE="5"></td> 
                    </tr>
                    <tr>  
                        <td name="ev2">*<?php echo $items->ArrayOfItems->string[1]->i; ?></td>
                        <td> <INPUT TYPE="RADIO" NAME="ev2" VALUE="1"> </td>  
                        <td> <INPUT TYPE="RADIO" NAME="ev2" VALUE="2"></td> 
                        <td> <INPUT TYPE="RADIO" NAME="ev2" VALUE="3"></td>  
                        <td> <INPUT TYPE="RADIO" NAME="ev2" VALUE="4"></td>
                        <td> <INPUT TYPE="RADIO" NAME="ev2" VALUE="5"></td>
                    </tr>
                    <tr>  
                        <td name="ev3">*<?php echo $items->ArrayOfItems->string[2]->i; ?></td>
                        <td> <INPUT TYPE="RADIO" NAME="ev3" VALUE="1"> </td>  
                        <td> <INPUT TYPE="RADIO" NAME="ev3" VALUE="2"></td> 
                        <td> <INPUT TYPE="RADIO" NAME="ev3" VALUE="3"></td>  
                        <td> <INPUT TYPE="RADIO" NAME="ev3" VALUE="4"></td>
                        <td> <INPUT TYPE="RADIO" NAME="ev3" VALUE="5"></td>
                    </tr>

                    <tr>  
                        <td name="ev4">*<?php echo $items->ArrayOfItems->string[3]->i; ?></td>
                        <td> <INPUT TYPE="RADIO" NAME="ev4" VALUE="1"> </td>  
                        <td> <INPUT TYPE="RADIO" NAME="ev4" VALUE="2"></td> 
                        <td> <INPUT TYPE="RADIO" NAME="ev4" VALUE="3"></td>  
                        <td> <INPUT TYPE="RADIO" NAME="ev4" VALUE="4"></td>
                        <td> <INPUT TYPE="RADIO" NAME="ev4" VALUE="5"></td>
                    </tr>
                    <tr>  
                        <td name="ev5">*<?php echo $items->ArrayOfItems->string[4]->i; ?></td>
                        <td> <INPUT TYPE="RADIO" NAME="ev5" VALUE="1"> </td>  
                        <td> <INPUT TYPE="RADIO" NAME="ev5" VALUE="2"></td> 
                        <td> <INPUT TYPE="RADIO" NAME="ev5" VALUE="3"></td>  
                        <td> <INPUT TYPE="RADIO" NAME="ev5" VALUE="4"></td>
                        <td> <INPUT TYPE="RADIO" NAME="ev5" VALUE="5"></td>
                    </tr>
                </table>
                <br><br>
                <input name="course_id" type="hidden" value='<?php echo $course_id ?>'/>
                <input name="instructor_id" type="hidden" value='<?php echo $instructor_id ?>'/>
                Comment
                <br>
                <input type="text" name="comment" id="textarea" />
                <br>
                <input type='submit' name='submit' value='Submit' style="width: 80px;height: 30px"/>
                <br> <br>
            </fieldset>
        </form>
    </div>
</html>
