<?php
    if(!empty($_POST['send']))
    {
        $nom_avatar = strtolower($_FILES['avatar']['name']);
        $chemin_temp = $_FILES['avatar']['tmp_name'];
        $chemin_avatar = 'avatars';
        $extension = array('png','jpg','jpeg','gif');
        print_r($chemin_temp);
        if(!empty($chemin_temp))
        {
            $img = explode('.', $nom_avatar);
            $extension_avatar = $img[1];
            if(in_array($extension_avatar, $extension))
            {
                move_uploaded_file($chemin_temp, ''.$chemin_avatar.'/'.$_FILES['avatar']['name'].'');
            }
            else
            {
                echo 'Veuillez choisir un avatar au format png, jpg, jpeg ou gif !';
            }
            
        }
    }

?>
<!DOCTYPE html>
<html>
<body>
    <form method="post" action="" enctype="multipart/form-data">
        <input type="file" name="avatar">
        <input type="submit" name="send" value="Envoyer">
    </form>
</body>
</html>