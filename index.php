<!DOCTYPE html> 
<html>
    <head>
        <title>Android Icon Creator</title>
        <meta charset="utf-8">
        <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <link href="css/grid.css" rel="stylesheet" media="screen" />
        <link href="css/style.css" rel="stylesheet" media="screen" />
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
        <script>
            $(document).ready(function(){
                var template = $('form p:first').clone();
                $('input[type=file]').live('change', function(){
                    $('form p:last').before(template.clone().val(''));
                });
            });
        </script>
    </head>
    <body>
        <h1>Android Icon Creator</h1>
        <p>Select your images that will be converted into icons</p>
        <form action="process.php" method="post" enctype="multipart/form-data">
            <p>
                <label>Image: </label>
                <input type="file" name="image[]" />
            </p>
            <p>
                <input type="submit" value="convert" />
            </p>
        </form>
    </body>
</html>
