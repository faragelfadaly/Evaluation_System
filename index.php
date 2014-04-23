<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <title>ITI Evaluation System</title>
        
        <link type="text/css" rel="stylesheet" href="styles/admin_style.css"/>        
        <link type="text/css" rel="stylesheet" href="styles/jquery-ui-1.10.0.custom.css"/>

        <script  type="text/javascript" src="styles/jquery-1.8.0.js"></script>
        <script type="text/javascript" src="styles/jquery-ui-1.10.0.custom.js"></script>        
        <script>            
            $(document).ready(function() {                    
                $("#b").button();
                $("#b").on("click", function() {                    
                    window.location.assign("login.php");                    
                });               
            });
        </script>   

    </head>
    <body>
        <div id="header">  
            <img id="im" src="images/3.jpg"
        </div>
        <div id="background">
            <input id="b" type="button" value="Login To System" onclick="window.location.assign('login.php')">
        </div>        
    </body>

</html>
