<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title></title>
    <link href="/css/style.css" media="screen" rel="stylesheet" type="text/css"/>
    <link href="/css/uniform.css" media="screen" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
</head>
<body>

<div class="TTWForm-container">
     
     
     <div id="form-title" class="form-title field">
          <h2>
               Submit a server
          </h2>
     </div>
   <?php echo validation_errors(); ?>
     
     <form action="" class="TTWForm" method="post" name="form">
         
          <div id="field1-container" class="field f_100">
               <label for="field1">
                    Address
               </label>
               <input type="text" name="address" id="field1">
          </div>
          
          
          <div id="field2-container" class="field f_100">
               <label for="field2">
                    E-mail
               </label>
               <input type="text" name="email" id="field2">
          </div>
          
          
          <div id="field3-container" class="field f_100">
               <label for="field3">
                    Web-site
               </label>
               <input type="text" name="site" id="field3">
          </div>
          
          
          <div id="form-submit" class="field f_100 clearfix submit">
               <input type="submit" value="Add">
          </div>
     </form>
</div>

</body>
</html>