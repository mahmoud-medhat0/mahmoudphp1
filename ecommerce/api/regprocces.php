<?php
$error_fields = array();
if (!(isset($_POST['first_name']) && !empty($_POST['first_name']))) {
    $error_fields[] = "first_name";
}
if (!(isset($_POST['last_name']) && !empty($_POST['last_name']))) {
    $error_fields[] = "last_name";
}
if (!(isset($_POST['phone']) && !empty($_POST['phone'])) && $_POST['phone'] > 11) {
    $error_fields[] = "phone";
}
if (!(isset($_POST['email']) && filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL))) {
    $error_fields[] = "email";
}
if (!(isset($_POST['password']) && strlen($_POST['password']) > 10)) {
    if (empty($_POST['password_confirmation']) && $_POST['password_confirmation'] != $_POST['password']) {
        $error_fields[] = "password_confirmation";
    } else {
        $error_fields[] = "password";
    }
}
if (!(isset($_POST['gender']) && !empty($_POST['gender']))) {
    $error_fields[] = "gender";
}
if ($error_fields) {
    header("Location:../register.php?error_fields=" . implode(",", $error_fields));
}
if(!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['email']) && !empty($_POST['phone']) && !empty($_POST['password']) && !empty($_POST['gender'])) {
    //connect db
    $conn = mysqli_connect('localhost','root','','e-commerce');
    echo "done connected";
    if (!$conn) {
        echo mysqli_connect_error();
        exit;
    }
    //escape data to db
    $name = mysqli_escape_string($conn,$_POST['first_name'].$_POST['last_name']);
    $email = mysqli_escape_string($conn, $_POST['email']);
    $phone = mysqli_escape_string($conn,$_POST['phone']);
    $password = mysqli_escape_string($conn, $_POST['password']);
    $gender = mysqli_escape_string($conn, $_POST['gender']);
    //insert data to db
    $query = "INSERT INTO users(name_en,email,password,gender) VALUES('$name','$email','$password','$gender');";
    if (mysqli_query($conn, $query)) {
        echo "your data has ben saved";
    } else {
        echo $query;
        echo mysqli_error($conn);
    }
    $query = "INSERT INTO user_phone(phone) VALUES('$phone');";
    if (mysqli_query($conn, $query)) {
        echo "your data has ben saved";
    } else {
        echo $query;
        echo mysqli_error($conn);
    }
    //close conn
    mysqli_close($conn);
}
