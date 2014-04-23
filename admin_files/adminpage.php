<?php
include './config.php';

// Get all intakes from database
$intakes_query = executeQuery("SELECT * FROM intake where isdeleted='0' order by intake_no");
$intakes = array();
while ($row = mysqli_fetch_assoc($intakes_query)) {
    $intakes[] = array(
        'id' => $row['id'],
        'intake_no' => $row['intake_no'],
        'year' => $row['year'],
        'current' => $row['current']
    );
}
// Get all tracks from database
$tracks_query = executeQuery("
    select t.id,t.name 
from track t join track_intake ti
on t.id= ti.track_id
where ti.intake_id=(select id from intake where current='1')
");

$tracks = array();
while ($row = mysqli_fetch_assoc($tracks_query)) {
    $tracks[] = array(
        'id' => $row['id'],
        'name' => $row['name']
    );
}

// Get all courses from database
$courses_query = executeQuery("SELECT * FROM course where isdeleted='0'");
$courses = array();
while ($row = mysqli_fetch_assoc($courses_query)) {
    $courses[] = array(
        'id' => $row['id'],
        'name' => $row['name'],
        'code' => $row['code']
    );
}

// Get all instructors from database
$instructors_query = executeQuery("SELECT * FROM `instructor` WHERE work='1'");
$instructors = array();
while ($row = mysqli_fetch_assoc($instructors_query)) {
    $instructors[] = array(
        'id' => $row['id'],
        'name' => $row['name']
    );
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Instructor Control Panel</title>        

        <script  type="text/javascript" src="../styles/jquery-1.8.0.js"></script>
        <script type="text/javascript" src="../styles/jquery-ui-1.10.0.custom.js"></script>
        <script  type="text/javascript" src="../styles/script.js"></script>        

        <link type="text/css" rel="stylesheet" href="../styles/jquery-ui-1.10.0.custom.css"/>

        <link type="text/css" rel="stylesheet" href="../styles/admin_style.css"/>

        <script src='../styles/combobox_script.js'></script>
        <link type="text/css" rel="stylesheet" href="style/admin_style.css">
        
        <style>

        </style>
    </head>          
    <body style="background-color: #aed0ea">        
        <div id="header">  
            <img id="im" src="../images/3.jpg" style="width: 100%"/>
        </div>
        <div id="tabs">
            <ul>
                <li><a href="#fragment-1"><span>Main</span></a></li>
                <li><a href="#fragment-2"><span>Instructor</span></a></li>
                <li><a href="#fragment-3"><span>Course</span></a></li>
                <li><a href="#fragment-4"><span>Track</span></a></li>
                <li><a href="#fragment-5"><span>Students</span></a></li>
                <li><a href="#fragment-6"><span>Evaluations</span></a></li>
                <li><a href="#fragment-7"><span>Intake</span></a></li>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="../login.php?value=Signout">Signout</a>            
            </ul>          
            <!-- ---------------------------- Administrator Main page ------------------------------------------- -->            

            <div id="fragment-1">
                <form method="post" action="main.php">
                    Intake:            
                    <select name="intake" id="intake_main">
                        <?php
                        foreach ($intakes as $intake) {
                            ?>
                            <option value="<?php echo "{$intake['id']}"; ?> " <?php
                            if ($intake['current'] == '1') {
                                echo "selected";
                            }
                            ?> > <?php echo "{$intake['intake_no']}"; ?> </option>
                                    <?php
                                }
                                ?>             
                    </select>    
                    <br>

                    Track:                    
                    <select name="track" id="track_main">                        
                    </select>                                                            
                    <br>                    

                    Course:
                    <select name="course" id="course_main">                        
                    </select>                    
                    <br>

                    Instructor:
                    <select name="instructor" id="instructor_main">                        
                    </select> 
                    <label>Scope</label>
                    <input type="text" name="scope" id="scope"/> 
                    <br>
                    
                    Due Date:
                    <input type="text" name="due_date" id="due_date_main" disabled value=""/> 
                    <br><br><br>
                    <input type="submit" name="instructor_eval" value="Instructor Evaluation" id="instructor_button_main"/>                    
                    <input type="submit" name="course_eval" value="Course Evaluation" id="course_button_main"/>
                    <span style="border: gold solid 5px">
                        <input type="submit" name="deactivate" value="Deactivate" id="deactivate_button_main"/>                        
                        <input type="submit" name="delete" value="Delete" id="delete_button_main"/>
                    </span>                    
                    <input type="button" name="edit" value="Edit" id="edit_button_main"/>
                    <input type="submit" name="late_students" value="Late Students" id="late_button_main"/>   
                </form> 

            </div>
            <!--------------------------------------------------------------------------------------------------- -->
            <!-- -------------------------------- Edit Form ----------------------------------------------------- --> 
            <div id="dialog-form" title="Edit Evaluation">                
                <form>
                    <fieldset>
                        <label for="intake">Intake</label>
                        <select id="edit_intake" >
                            <?php
                            foreach ($intakes as $intake) {
                                ?>
                                <option value="<?php echo "{$intake['id']}"; ?> " <?php
                                if ($intake['current'] == '1') {
                                    echo "selected";
                                }
                                ?> > <?php echo "{$intake['intake_no']}"; ?> </option>
                                        <?php
                                    }
                                    ?>             
                        </select> 
                        <br><br>

                        <label for="track">Track</label>
                        <select id="edit_track">
                            <?php
                            foreach ($tracks as $track) {
                                ?>
                                <option value="<?php echo "{$track['id']}"; ?>"><?php echo "{$track['name']}"; ?></option>
                                <?php
                            }
                            ?>                      
                        </select>      
                        <br><br>

                        <label for="course">Course</label>
                        <select id="edit_course">
                            <?php
                            foreach ($courses as $course) {
                                ?>
                                <option value="<?php echo "{$course['id']}"; ?>"><?php echo "{$course['name']}"; ?></option>
                                <?php
                            }
                            ?>                      
                        </select>            
                        <br><br>

                        <label for="instructor">Instructor</label>
                        <select id="edit_instructor" >
                            <?php
                            foreach ($instructors as $instructor) {
                                ?>
                                <option value="<?php echo "{$instructor['id']}"; ?>"><?php echo "{$instructor['name']}"; ?></option>
                                <?php
                            }
                            ?>                      
                        </select>            
                        <select id="edit_scope" >
                            <option value="lec">Lec</option>
                            <option value="lab">Lab</option>
                        </select>
                        <input type="text" id="edit_date"/>
                        

                    </fieldset>
                </form>
                <div id="edit_eval_message"></div>
            </div>
            <!-- ----------------------------instructor------------------------------------------- -->
            <div id="fragment-2">
                <form method="post" action="instructor.php">
                    Name:
                    <select name="instructor_id" id="instructor_name">
                        <?php
                        foreach ($instructors as $instructor) {
                            ?>
                            <option value="<?php echo "{$instructor['id']}"; ?>"><?php echo "{$instructor['name']}"; ?></option>
                            <?php
                        }
                        ?>                      
                    </select>            
                    <br>
                    Title:
                    <input type="text" name="instructor_title" id="instructor_title"/> 
                    <br><br>
                    <input type="submit" name="add" value="Add/Edit"/> 
                    <input type="submit" name="delete" value="Delete"/>

                </form>
            </div>
            <!-- -------------------------------course---------------------------------------- -->
            <div id="fragment-3">
                <form method="post" action="course.php">
                    Name:
                    <select name="course_id" id="course_name">
                        <?php
                        foreach ($courses as $course) {
                            ?>
                            <option value="<?php echo "{$course['id']}"; ?>"><?php echo "{$course['name']}"; ?></option>
                            <?php
                        }
                        ?>                      
                    </select>            
                    <br>
                    Code:
                    <input type="text" name="course_code" id="course_code"/> 
                    <br><br>
                    <input type="submit" name="add" value="Add/Edit"/>
                    <input type="submit" name="delete" value="Delete"/>

                </form>
            </div>
            <!-- --------------------------------track--------------------------------------- -->
            <div id="fragment-4">
                <form method="post" action="track.php">
                    Name:
                    <select name="track_id" id="track_name">
                        <option value="-2">--add track--</option>
                        <?php
                        foreach ($tracks as $track) {
                            ?>
                            <option value="<?php echo "{$track['id']}"; ?>"><?php echo "{$track['name']}"; ?></option>
                            <?php
                        }
                        ?>                        
                    </select>

                    <br>                    
                    Supervisor:
                    <span id="inst">
                    </span>
                    <select name="hidinstructor_id" id="hidinstructor_name">
                        <?php
                        foreach ($instructors as $instructor) {
                            ?>
                            <option value="<?php echo "{$instructor['id']}"; ?>"><?php echo "{$instructor['name']}"; ?></option>
                            <?php
                        }
                        ?>                      
                    </select>
                    <br><br>
                    <input type="submit" name="add" value="Add/Edit"/>
                    <input type="submit" name="delete" value="Delete"/>

                </form>                
            </div>
            <!-- -------------- Students ---------------------------------------------- -->
            <div id="fragment-5">
                <form method="post" action="students.php">
                    <div style="background-color: #aed0ea" class="ui-tabs ui-widget ui-widget-content ui-corner-all">                        
                        <label>Track :&nbsp;</label>
                        <select id="students_track" name="student_track">
                            <?php
                            foreach ($tracks as $track) {
                                ?>
                                <option value="<?php echo "{$track['id']}"; ?>"><?php echo "{$track['name']}"; ?></option>
                                <?php
                            }
                            ?>
                        </select>            
                        <br>

                        <label>Name :&nbsp;</label>
                        <select id="students_student" name="student_name">                         
                        </select>            
                        <br>
                        <label>Username :&nbsp;</label>
                        <input type="text" name="username" id="username" value="" disabled/>                    
                        <br>
                        <input type="submit" name="add" value="Add"/>                    
                        <input type="submit" name="edit" value="Edit"/>
                        <input type="submit" name="delete" value="Delete"/>
                        <br>
                    </div>
                    <br>
                    <div id="trans" style="background-color: #aed0ea" class="ui-tabs ui-widget ui-widget-content ui-corner-all" >
                        <label style="font-size: large; font-weight: 800; font-family: sans-serif">Transfer Student</label>
                        <br>

                        Track:
                        <select id="students_transfer_track" name="track_old">
                            <?php
                            foreach ($tracks as $track) {
                                ?>
                                <option value="<?php echo "{$track['id']}"; ?>"><?php echo "{$track['name']}"; ?></option>
                                <?php
                            }
                            ?>
                        </select>            
                        <br>
                        Name
                        <select id="students_transfer_student" name="student_transfer_name">

                        </select> 
                        <br>
                        New Track:
                        <select name="track_new" id="track_new">                                                        
                        </select>            
                        </select>            
                        <br><br>
                        <input type="submit" name="transfer" value="Transfer"/>
                </form>
            </div>
        </div>
        <!-- --------------------- Evaluations ------------------------------------ -->
        <div id="fragment-6">
            
                Track:
                <select name="track_id" id="track_id_6">
                    <?php
                    foreach ($tracks as $track) {
                        ?>
                        <option value="<?php echo "{$track['id']}"; ?>"><?php echo "{$track['name']}"; ?></option>
                        <?php
                    }
                    ?>
                </select>            
                <br>
                Course:
                <select name="course_id" id="course_id_6">
                    <?php
                    foreach ($courses as $course) {
                        ?>
                        <option value="<?php echo "{$course['id']}"; ?>"><?php echo "{$course['name']}" . " [{$course['code']}]"; ?></option>
                        <?php
                    }
                    ?>
                </select>            
                <br><br>

                <div id="inst" class="ui-tabs ui-widget ui-widget-content ui-corner-all">                    
                    <label>Instructor</label>
                    <br><br>
                    <label>&nbsp;&nbsp;&nbsp;&nbsp;Lecture</label>
                    <select name="instructor_lec_id" id="instructor_lec_id_6">
                        <?php
                        foreach ($instructors as $instructor) {
                            ?>
                            <option value="<?php echo "{$instructor['id']}"; ?>"><?php echo "{$instructor['name']}"; ?></option>
                            <?php
                        }
                        ?>                    
                    </select>            
                    <label>&nbsp;&nbsp;&nbsp;&nbsp;Lab</label>
                    <select name="instructor_lab_id" id="instructor_lab_id_6">
                        <?php
                        foreach ($instructors as $instructor) {
                            ?>
                            <option value="<?php echo "{$instructor['id']}"; ?>"><?php echo "{$instructor['name']}"; ?></option>
                            <?php
                        }
                        ?>                    
                    </select>
                    <br>
                </div>
                <br>
                Due Date:
                <input type="text" id="datepicker"/>
                <br><br>        
                <input type="button" id="activate_eval" value="Activate" onclick="addEval()"/>
                <div id="add_eval_message"></div>
        </div>
        <!-- ------------------------------intake----------------------------------------- -->
        <div id="fragment-7">
            <form method="post" action="intake.php">
                Intake no:
                <select name="intake_no" id="intake_no">
                    <?php
                    foreach ($intakes as $intake) {
                        ?>
                        <option value="<?php echo "{$intake['id']}"; ?> " <?php
                        if ($intake['current'] == '1') {
                            echo "selected";
                        }
                        ?> > <?php echo "{$intake['intake_no']}"; ?> </option>
                                <?php
                            }
                            ?>                    
                </select>            
                <br><br>
                <label>Year</label>
                <input type="text" id="year" name="year" value=""/>                    
                <br><br>
                <input type="submit" name="add" value="Add"/>
                <input type="submit" name="set_as_current" value="Set as current"/>                    
                <input type="button" id="delete" name="delete" value="Delete"/>
            </form>

            <!----- Dialog of Delete Intake ----->                        
            <div id='dialog' title='Confirm Intake Delete' style="display: none">                   
                <label> Delete All Tracks</label>
                <input type='checkbox' id="checkbox1" value='checkbox1'/>
                <br><br>
                <label>Delete All  Students</label>
                <input type='checkbox' id="checkbox2" value='checkbox2'/>                    
            </div>
            <!-- --------------------------------------------------------------------------------------- -->
        </div>
        <div id="delete_message"></div>
    </div>


</body>
</html>
