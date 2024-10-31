<!DOCTYPE html>
<html>
   <head>
      <title>Gmail Sender</title>
      <link rel="stylesheet" href="style.css">
   </head>
   <body>
      <div class="wrapper">
         <form method="post" action="index.php">
            <h2>Gmail Sender App</h2><br>
            Email To :<br>
            <input type="text" name="email"><br>
            Subject :<br>
            <input type="text" name="subject"><br>
            Body :<br>
            <textarea name="body"></textarea><br>
            <input type="submit" value="SEND" name="submit">            
         </form>
         <?php
         if(isset($_POST['submit'])){
            $url = "https://script.google.com/macros/s/AKfycbxjyNbPGyTAyaKe2EnL10ULQTv2eG5OxO4FdQrH4mM661JtDepjPrZ9xkWzmsHcrVAZ/exec";
            $ch = curl_init($url);
            curl_setopt_array($ch, [
               CURLOPT_RETURNTRANSFER => true,
               CURLOPT_FOLLOWLOCATION => true,
               CURLOPT_POSTFIELDS => http_build_query([
                  "recipient" => $_POST['email'],
                  "subject"   => $_POST['subject'],
                  "body"      => $_POST['body']
               ])
            ]);
            $result = curl_exec($ch);
            echo $result;
         }
         ?>
      </div>
      
   </body>
</html>