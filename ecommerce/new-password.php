<?php

use App\Database\Models\User;
use App\Http\Requests\Validation;

$title = "Verify Your Account";

include "layouts/header.php";
include "middlewares/NotVerified.php";
include "middlewares/guest.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // validation
    $validation = new Validation;
    $validation->setInput('password')->setValue($_POST['password'])->required()->regex('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,32}$/', 'the password must be greater than 8 and lesser than 32 ,one number, uppercase,lower character, special character');
    $validation->setInput('password_confirmation')->setValue($_POST['password_confirmation'])->required()->confirmed($_POST['password_confirmation']);
    if (empty($validation->getErrors())) {
        $user = new User;
        if(isset($_SESSION['email'])){
        $user->setEmail($_SESSION['email'])->getuser();
        $result = $user->setPassword($_POST['password'])->setUpdated_at(date('Y-m-d H:i:s'))->updateassword();
        $success = "<div class='alert alert-success text-center'> password updated   , You will be redirected to login page shortly ... </div>";
        header('refresh:3; url=login.php');
        }else{
            header('location:login.php');die;
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
                        <a class="active" data-toggle="tab" href="#lg1">
                            <h4> <?= $title ?></h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <form action="" method="post">
                                        <?= $error ?? "" ?>
                                        <?= $success ?? "" ?>
                                        <input type="password" name="password" placeholder="password">
                                        <?= isset($validation) ? $validation->getMessage('password') : '' ?>
                                        <input type="password" name="password_confirmation" placeholder="password confirmation">
                                        <?= isset($validation) ? $validation->getMessage('password_confirmation') : '' ?><div class="button-box">
                                            <button type="submit"><span>Verify</span></button>
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
include "layouts/scripts.php";
?>