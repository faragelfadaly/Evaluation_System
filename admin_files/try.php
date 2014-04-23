UPDATE 'evaluation' 
SET 
'intake_id'= ,
'track_id'= ,
'inst_id'= ,
'course_id'= ,
'due_date'= ,
WHERE 1



delimiter |

CREATE TRIGGER trackIntakeLink AFTER INSERT ON track
FOR EACH ROW BEGIN
INSERT INTO track_intake SET track_id = NEW.id,
intake_id=(select id from intake where current='1')    
END


////////////////////////////////////////////////////////////////////////////////////////////
CREATE PROCEDURE addEval(IN trackId INT, IN courseId INT , dueDate TEXT , lecInstId INT,labInstId INT, evalscope VARCHAR)
BEGIN
DECLARE eval_id int default 0;

INSERT INTO `evaluation` (`intake_id`, `track_id`,`course_id`,`due_date`) 
VALUES ((select id from intake where current='1'),trackId,courseId,dueDate);

set eval_id = last_insert_id();
if eval_id <> 0 then

INSERT INTO `eval_inst_evtable`(`eval_id`, `inst_id`,`scope`) VALUES (eval_id,lecInstId,'lec');
INSERT INTO `eval_inst_evtable`(`eval_id`, `inst_id`,`scope`) VALUES (eval_id,labInstId,'lab');

END
////////////////////////////////////////////////////////////////////////////////////////////
CREATE PROCEDURE addEval(IN trackId INT, IN courseId INT , dueDate TEXT , lecInstId INT,labInstId INT, evalscope VARCHAR)
BEGIN

set @eval_id =0;

INSERT INTO `evaluation` (`intake_id`, `track_id`,`course_id`,`due_date`) 
VALUES ((select id from intake where current='1'),trackId,courseId,dueDate);

@eval_id=last_insert_id();
INSERT INTO `eval_inst_evtable`(@eval_id, `inst_id`,`scope`) VALUES (eval_id,lecInstId,'lec');

END;	




/////////////////////////////////////////////////// Add Evaluation  ////////////////////////////////////////////
    
        alert("adddddddddddd");
        $.ajax({
            url: "evaluations.php",
            type: "POST",
            data: {
                track_id: $("#track_id_6").val(),
                course_id: $("#course_id_6").val(),
                instructor_lec_id: $("#instructor_lec_id_6").val(),
                instructor_lab_id: $("#instructor_lab_id_6").val(),
                due_date: $("#due_date_6").val()
            },
            success: function(resp) {
                alert(resp);
            }
        });
    