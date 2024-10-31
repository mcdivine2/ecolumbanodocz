

                                            
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
            echo '<div class="alert alert-success" style="text-align: center;margin-top: 100px;font: size 20px;"><b>Email Sent Successfully!</b></div><script> setTimeout(function() {  window.history.go(-1); }, 1000); </script>';
         }
         ?>
