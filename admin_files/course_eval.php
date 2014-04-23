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
        include './config.php';


        $link = connectToDB();
        $eval_id = $_GET['eval'];

        $evalquery = mysqli_query($link, "call getCourseEval($eval_id);");
        if ($evalquery) {
            ?>
            <br>
            <div style="text-align: center; color: red; font-style: oblique; font-size: 30px;width:75%; margin-left: 15%">
                
                <label><u>Course evaluation</u></label>

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
                        $items = simplexml_load_file("../courseevalitems.xml");
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
