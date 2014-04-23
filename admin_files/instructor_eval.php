<html>
    <head>
        <script type="text/javascript" charset="utf-8" src="../styles/js/jquery.js"></script>
        <script type="text/javascript" charset="utf-8" src="../styles/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8" src="../styles/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="../styles/js/jquery-ui-1.10.0.custom.js"></script>

        <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.3.0/build/cssreset/reset-min.css"/>

        <style type="text/css" title="currentStyle">

            @import "../styles/css/demo_table.css";
            @import "../styles/css/demo_table_jui.css";
            @import "../styles/css/demo_page.css";
            @import "../styles/css/jquery.dataTables.css";
            @import "../styles/css/jquery.dataTables_themeroller.css"; 
            @import "../styles/jquery-ui-1.10.0.custom.css";             
            @media print
            {
                input{display: none;}
                img{display:none;}
            }
        </style>
        <script>
            $(document).ready(function() {
                
                function printpage() {
                    window.print();
                }
 
                $('#courseevaluation').dataTable({
                    "aaSorting": [[4, "desc"]],
                    bJQueryUI: true,
                    sPaginationType: "full_numbers"
                });
                
            });

        </script>
    </head>
    <body>
        <br></br>
        <input type="button" value="Back" id="back" onclick='window.location.assign("adminpage.php")'/>
        <?php
        $eval_inst_id = $_GET['eval'];
        include './config.php';

        $link = connectToDB();
        $query = executeQuery("select distinct t.name as tname ,i.name as iname , c.name as cname
                       from track t , instructor i , course c , evaluation e , eval_inst_evtable evt  
                        where evt.id='$eval_inst_id'                            
                            and e.track_id=t.id
                            and e.course_id =c.id
                            and evt.inst_id=i.id
                            and e.id=evt.eval_id
        ");

        while ($row = mysqli_fetch_assoc($query)) {
            echo"<br>";
            echo "Track Name : " . "{$row['tname']}" . "<br>";
            echo "Instructor Name : " . "{$row['iname']}" . "<br>";
            echo "Course Name : " . "{$row['cname']}" . "<br>";
        }
        $eval_id = $_GET['eval'];

        $evalquery = mysqli_query($link, "call getInstructorEval($eval_id);");
        if ($evalquery) {
            ?>
            <br>
            <div style="text-align: center; color: red; font-style: oblique; font-size: 30px;width:75%; margin-left: 15%">

                <label><u>Instructor evaluation</u></label>

                <br><br>
                <table id="courseevaluation" class="display" style="color: blue;">
                    <thead>
                        <tr>
                            <th>eval</th>
                            <th>1</th>
                            <th>2</th>
                            <th>3</th>
                            <th>4</th>
                            <th>5</th>
                            <th>Percentage</th>
                            <th>Total</th>
                            <th>No</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $items = simplexml_load_file("../instevalitems.xml");
                        $dom = dom_import_simplexml($items)->ownerDocument;
                        $dom->formatOutput = true;
                        $percsum = 0;
                        $x = 0;
                        while ($row = mysqli_fetch_assoc($evalquery)) {
                            $total = $row['1'] * 1 + $row['2'] * 2 + $row['3'] * 3 + $row['4'] * 4 + $row['5'] * 5;
                            $no = $row['1'] + $row['2'] + $row['3'] + $row['4'] + $row['5'];
                            $percent = 0;
                            if ($no > 0) {
                                $percent = ($total / ($no * 5)) * 100;
                            }
                            $percsum+=$percent;
                            echo "<tr class='gradeU'>
                                <td>{$items->ArrayOfItems->string[$x]->i}</td>        
                                <td>{$row['1']}</td>
                                <td>{$row['2']}</td>
                                <td>{$row['3']}</td>
                                <td>{$row['4']}</td>
                                <td>{$row['5']}</td>
                                <td>$percent%</td>
                                <td>$total</td>
                                <td>$no</td>
                              </tr>";
                            $x++;
                        }
                        ?>
                    </tbody>
                </table>
                </br></br>

                <label>Percentage average : <?php echo $percsum / 5; ?>%</label>
                </br></br>
                <input type="button" value="Print this Page" onclick="window.print();"/>
                <?php
            }
            ?>
        </div>
    </body>
</html>
