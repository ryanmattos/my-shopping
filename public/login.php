<?php
    include 'connection.php';
    $username = $_POST['username'];
    $pass = $_POST['password'];

    $encrypted_pass = md5($pass);
    $sql = "SELECT * FROM user WHERE username='$username' AND pass='$encrypted_pass'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        // while($row = mysqli_fetch_assoc($result)) {
        //     echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
        // }

        session_start();

        $_SESSION["user"] = $username;
        $_SESSION["pass"] = $encrypted_pass;

        header('Location: index.html');

    } else {
        echo "Usuário ou senha incorretos";
    }
    

?>