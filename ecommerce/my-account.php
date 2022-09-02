<?php

use App\Services\Media;
use App\Database\Models\User;
use App\Http\Requests\Validation;

$title = "My Account";
include "layouts/header.php";
include "layouts/navbar.php";
include "layouts/breadcrumb.php";
include "middlewares/auth.php";
if (isset($_SESSION['user'])) {
    $email = $_SESSION['user']->email;
    $user_name = new User;
    $namen = $user_name->setEmail($email)->getNamen()->fetch_array();
    // print_r($namen['name_en']);
    $namestored = explode('_', $namen['name_en']);
    $user = new User;
    $phonenew = new User;
    $phoneold = $user->getuserbyid($_SESSION['user']->id)->fetch_array();
    $phone = $phoneold['phone'];
} else {
    header('location:index.php');
    die;
}
if (isset($_POST['upload-image'])) {
    if ($_FILES['image']['error'] == 0) {
        $imageService = new Media;
        $imageService->setFile($_FILES['image'])
            ->size(1024 * 1024)->extension(['png', 'jpg', 'jpeg']);
        if (empty($imageService->getErrors())) {
            $imageService->upload('assets/img/users/');
            $user = new User;
            $user->setEmail($_SESSION['user']->email)->setImage($imageService->getFileName());
            if ($user->updateImage()) {
                if ($_SESSION['user']->image != 'default.jpg') {
                    $imageService->delete('assets/img/users/' . $_SESSION['user']->image);
                }
                $_SESSION['user']->image = $imageService->getFileName();
                $successfullUpload = "<div class='alert alert-success text-center'> Profile Picture Uploaded Successfully </div>";
            } else {
                $failedUpload = "<div class='alert alert-danger text-center'> Upload Failed </div>";
            }
        }
    }
}
$validation = new Validation;
if (isset($_POST['submitname_phone'])) {
    $validation->setInput('fname')->setValue($_POST['fname'])->required();
    $validation->setInput('sname')->setValue($_POST['sname'])->required();
    $validation->setInput('gender')->setValue($_POST['gender'])->required()->in(['m', 'f']);
    $validation->setInput('phone')->setValue($_POST['phone'])->required()->regex('/^01[0-2,5]\d{8}$/', 'supported number operator is 010,011,012,015');
    if (empty($validation->getErrors())) {
        $namesend = $_POST['fname'] . "_" . $_POST['sname'];
        $ugender = new User;
        $ugender->setEmail($_SESSION['user']->email)->setGender($_POST['gender']);
        $user = new User;
        $user->setInput('name_en')->setValue($namesend)->setEmail($_SESSION['user']->email);
        $phonesend = new User;
        $phonesend->setInput('phone')->setValue($_POST['phone'])->setId($_SESSION['user']->id);
        if ($user->update() && $phonesend->updatephone() && $ugender->updateGender()) {
            $success = "<div class='alert alert-success text-center'> Update Done </div>";
            $namen = $user_name->setEmail($email)->getNamen()->fetch_array();
            $namestored = explode('_', $namen['name_en']);
            $phone = $_POST['phone'];
            $colaap1 = 'aria-expanded="true"';
        }
    }
    if (isset($_POST['upload-image'])) {
        if ($_FILES['image']['error'] == 0) {
            $imageService = new Media;
            $imageService->setFile($_FILES['image'])
                ->size(1024 * 1024)->extension(['png', 'jpg', 'jpeg']);
            if (empty($imageService->getErrors())) {
                $imageService->upload('assets/img/users/');
                $user = new User;
                $user->setEmail($_SESSION['user']->email)->setImage($imageService->getFileName());
                if ($user->updateImage()) {
                    if ($_SESSION['user']->image != 'default.jpg') {
                        $imageService->delete('assets/img/users/' . $_SESSION['user']->image);
                    }
                    $_SESSION['user']->image = $imageService->getFileName();
                    $successfullUpload = "<div class='alert alert-success text-center'> Profile Picture Uploaded Successfully </div>";
                } else {
                    $failedUpload = "<div class='alert alert-danger text-center'> Upload Failed </div>";
                }
            }
        }
    }
}
if (isset($_POST['passwordchange'])) {
    $validationpass = new Validation;
    $passverifiey = new User;
    $result = $passverifiey->setEmail($_SESSION['user']->email)->getuser()->fetch_object();
    $validation->setInput('oldpass')->setValue($_POST['oldpass'])->required()->regex('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,32}$/', 'the passworn must be greater than 8 and lesser than 32 ,one number, uppercase,lower character, special character');
    $validation->setInput('password')->setValue($_POST['password'])->required()->regex('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,32}$/', 'the passworn must be greater than 8 and lesser than 32 ,one number, uppercase,lower character, special character');
    $validation->setInput('password_confirmation')->setValue($_POST['password_confirmation'])->required()->confirmed($_POST['password_confirmation']);
    if (empty($validation->getErrors())) {
        $result = $passverifiey->setEmail($_SESSION['user']->email)->getuser()->fetch_object();
        if (password_verify($_POST['oldpass'], $result->password)) {
            $passverifiey->setInput('password')->setValue($_POST['password'])->setEmail($_SESSION['user']->email);
            if ($passverifiey->updatepass()) {
                $success1 = "<div class='alert alert-success text-center'> Update Done </div>";
            }
        } else {
            $passerror = "<p class='text-danger font-weight-bold'>Password Old Not Correct</p>";
        }
    }
}
?>
<!-- my account start -->
<div class="checkout-area pb-80 pt-100">
    <div class="container">
        <div class="row">
            <div class="ml-auto mr-auto col-lg-9">
                <?php
                if ($_SESSION['user']->image == 'default.jpg') {
                    if ($_SESSION['user']->gender == 'm')
                        $image = 'male.jpg';
                } elseif ($_SESSION['user']->gender == 'f') {
                    $image = 'female.jpg';
                } else {
                    $image = $_SESSION['user']->image;
                }
                ?>
                <div class="checkout-wrapper">
                    <div id="faq" class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>1</span> <a data-toggle="collapse" <?= $colaap1 ?? 'aria-expanded="flase"' ?>data-parent="#faq" href="#my-account-1">Edit your account information </a></h5>
                            </div>

                            <div id="my-account-1" class="panel-collapse collapse show">
                                <center>
                                <?= $success ?? "" ?>
                                <label for="file">
                                    <img src="assets/img/users/<?= $image ?>" id="image" class="w-100 rounded-circle" style="cursor:pointer;" alt="">
                                </label>
                                <form action="" method="post" enctype="multipart/form-data">
                                    <input type="file" name="image" class="d-none" id="file" onchange="loadFile(event)">
                                    <div class="billing-btn">
                                        <button type="submit" class="d-none" name="upload-image" id="upload-image">Upload</button>
                                    </div>
                                </form>
                                </center>
                                <form class="form-group" method="post">
                                    <div class="panel-body">
                                        <div class="billing-information-wrapper">
                                            <div class="account-info-wrapper">
                                                <h4>My Account Information</h4>
                                                <h5>Your Personal Details</h5>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="billing-info">
                                                        <label>First Name</label>
                                                        <input type="text" name="fname" value="<?= $namestored[0] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="billing-info">
                                                        <label>Last Name</label>
                                                        <input type="text" name="sname" value="<?= $namestored[1] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="billing-info">
                                                        <label>Telephone</label>
                                                        <input type="number" name="phone" value="<?= $phone ?>">
                                                        <?= $validation->getmessage('phone') ?? "" ?>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="billing-info">
                                                        <label for="gender">gender</label>
                                                        <select name="gender" id="gender">
                                                            <option <?php
                                                                    if ($_POST['gender'] == 'm') {
                                                                        echo "selected";
                                                                    } ?> value="m">male</option>
                                                            <option <?php
                                                                    if ($_POST['gender'] == 'f') {
                                                                        echo "selected";
                                                                    }
                                                                    ?> value="f">female</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="billing-back-btn">
                                                <div class="billing-back">
                                                    <a href="#"><i class="ion-arrow-up-c"></i> back</a>
                                                </div>
                                                <div class="billing-btn">
                                                    <input name="submitname_phone" value="update" type="submit">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            </form>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>2</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-2">Change your password </a></h5>
                            </div>
                            <div id="my-account-2" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <?= $success1 ?? "" ?>
                                    <form class="form-group" method="post">
                                        <div class="billing-information-wrapper">
                                            <div class="account-info-wrapper">
                                                <h4>Change Password</h4>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="billing-info">
                                                        <label>OldPassword</label>
                                                        <input type="password" name="oldpass">
                                                        <?= $validation->getmessage('oldpass') ?>
                                                        <?= $passerror ?? "" ?>
                                                    </div>
                                                    <div class="billing-info">
                                                        <label>Password</label>
                                                        <input type="password" name="password">
                                                        <?= $validation->getmessage('password') ?>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="billing-info">
                                                        <label>Password Confirm</label>
                                                        <input type="password" name="password_confirmation">
                                                        <?= $validation->getmessage('password_confirmation') ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="billing-back-btn">
                                                <div class="billing-back">
                                                    <a href="#"><i class="ion-arrow-up-c"></i> back</a>
                                                </div>
                                                <div class="billing-btn">
                                                    <input name="passwordchange" value="update" type="submit">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>3</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-3">Modify your address book entries </a></h5>
                            </div>
                            <div id="my-account-3" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="billing-information-wrapper">
                                        <div class="account-info-wrapper">
                                            <h4>Address Book Entries</h4>
                                        </div>
                                        <div class="entries-wrapper">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 d-flex align-items-center justify-content-center">
                                                    <div class="entries-info text-center">
                                                        <p>Farhana hayder (shuvo) </p>
                                                        <p>hastech </p>
                                                        <p> Road#1 , Block#c </p>
                                                        <p> Rampura. </p>
                                                        <p>Dhaka </p>
                                                        <p>Bangladesh </p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 d-flex align-items-center justify-content-center">
                                                    <div class="entries-edit-delete text-center">
                                                        <a class="edit" href="#">Edit</a>
                                                        <a href="#">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="billing-back-btn">
                                            <div class="billing-back">
                                                <a href="#"><i class="ion-arrow-up-c"></i> back</a>
                                            </div>
                                            <div class="billing-btn">
                                                <button type="submit">Continue</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>4</span> <a href="wishlist.php">Modify your wish list
                                    </a></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var loadFile = function(event) {
        var output = document.getElementById('image');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
            document.getElementById('upload-image').classList.remove('d-none');
        }
    };
</script>

<!-- my account end -->
<?php
include "layouts/footer.php";
include "layouts/scripts.php";
?>