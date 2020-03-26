<?php
    include 'connection.php';
    $username = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $encrypted_pass = md5($pass);

    $sql = "SELECT * FROM user WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        // while($row = mysqli_fetch_assoc($result)) {
        //     echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
        // }

        echo "Já existe um usuário cadastrado com esse nome de usuário.";
        sleep(3);
        header('Location: login.html');

    } else {
        session_start();
        $_SESSION["user"] = $username;
        $_SESSION["pass"] = $encrypted_pass;

        $sql = "INSERT INTO `user` (`username`, `email`, `pass`) VALUES ('$username', '$email', '$encrypted_pass')";
        $result = mysqli_query($conn, $sql);

        header('Location: index.html');
    }
    

?>