<?php

use App\Database\Models\User;
use App\Http\Requests\Validation;
use App\Mails\VerificationCode;

$title = "Register";
include "layouts/header.php";
include "layouts/navbar.php";
include "layouts/breadcrumb.php";
include "middlewares/guest.php";
$validation = new Validation;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $validation->setInput('first_name')->setValue($_POST['first_name'])->required()->min(2)->max(32);
    $validation->setInput('last_name')->setValue($_POST['last_name'])->required()->min(2)->max(32);
    $validation->setInput('email')->setValue($_POST['email'])->required()->regex('/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/')->unique('users', 'email');
    $validation->setInput('phone')->setValue($_POST['phone'])->required()->regex('/^01[0-2,5]\d{8}$/', 'supported number operator is 010,011,012,015')->unique('user_phone', 'phone');
    $validation->setInput('password')->setValue($_POST['password'])->required()->regex('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,32}$/', 'the passworn must be greater than 8 and lesser than 32 ,one number, uppercase,lower character, special character');
    $validation->setInput('password_confirmation')->setValue($_POST['password_confirmation'])->required()->confirmed($_POST['password_confirmation']);
    $validation->setInput('gender')->setValue($_POST['gender'])->required()->in(['m', 'f']);
    if (empty($validation->getErrors())) {
        $verificationcode = rand(100000, 999999);
        $newuser = new User;
        $newuser->setFirst_name($_POST['first_name'])->setLast_name($_POST['last_name'])->setEmail($_POST['email'])->setPhone($_POST['phone'])->setPassword($_POST['password'])->setGender($_POST['gender'])->setVerification_code($verificationcode)->setCreated_at(date('Y-m-d H:i:s'));
        if ($newuser->create()) {
            $verifiyemail = new VerificationCode;
            $subject = "Verification Code";
            $body = "<p>Hello {$_POST['first_name']}</p>
        <p>Your Verification Code is : <b style='color:blue;'>" . $verificationcode . "</b></p>
        <p>Thank You.</p>";
            $verifiyemail->send($_POST['email'], $subject, $body);
            $_SESSION['email'] = $_POST['email'];
            header('Location: checkverifiy.php?page=register');
        } else {
            $error = "<div class='alert alert-danger text-center'> Please Try Again Later </div>";
        }
    }
}
?>
<div class="login-register-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                <div class="login-register-wrapper">
                    <div class="login-register-tab-list nav">
                        <a class="active" data-toggle="tab" href="#lg2">
                            <h4> register </h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg2" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <?= $error ?? " " ?>
                                    <form method="post">
                                        <input type="text" name="first_name" placeholder="First Name" value="<?= $validation->getValuestored('first_name'); ?>">
                                        <?= $validation->getmessage('first_name') ?>
                                        <input type="text" name="last_name" placeholder="Last Name" value="<?= $validation->getValuestored('last_name'); ?>">
                                        <?= $validation->getmessage('last_name') ?>
                                        <input type="email" name="email" placeholder="Email Address" value="<?= $validation->getValuestored('email'); ?>">
                                        <?= $validation->getmessage('email') ?>
                                        <input type="tel" name="phone" placeholder="Phone" value="<?= $validation->getValuestored('phone'); ?>">
                                        <?= $validation->getmessage('phone') ?>
                                        <input type="password" name="password" placeholder="Password">
                                        <?= $validation->getmessage('password') ?>
                                        <input type="password" name="password_confirmation" placeholder="Password Confirmation">
                                        <?= $validation->getmessage('password_confirmation') ?>
                                        <select name="gender" class="form-control my-3" id="">
                                            <option <?= $validation->getValuestored('gender') == 'm' ? 'selected' : '' ?> value="m">Male</option>
                                            <option <?= $validation->getValuestored('gender') == 'f' ? 'selected' : '' ?> value="f">Female</option>
                                        </select>
                                        <div class="button-box">
                                            <button type="submit"><span>Register</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include "layouts/footer.php";
include "layouts/scripts.php";
?>