

                                            
 <?php
         if(isset($_POST['submit'])){
            $url = "https://script.google.com/macros/s/AKfycbxeZj2u3vOe0nPCfRb4gNAtCdUcgh8eCWMRagQ3DRsvQRq5hn_rGnWQjSKsdLoIy62XXA/exec";
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
