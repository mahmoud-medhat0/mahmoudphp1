<?php
include('includes/session.php');
if (isset($_POST['submit'])){
    $number=$_POST['number'];
    $a=strlen($number);
    if ($a < 11){
        $er="please enter vaild number";
    }else{
        $_SESSION['number']=$number;
        header("Location:survey.php");
    }
}

?>
<!doctype html>
<html lang="en">
  <head>
    <title>Number</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
  <form method="POST" class="text-center border border-primary mx-auto">
  <div class="form-group">
    <label for="exampleInputEmail1">Enter Phone Number</label>
    <input name="number" type="number" class="form-control" placeholder="Enter Number">
    <small id="emailHelp" class="form-text text-muted">we happy for your serveve you.</small>
    <?php if(isset($er)){
        echo $er;
    } ?>
  </div>
  <button name="submit" type="submit" class="btn btn-primary">start Survey</button>
</form>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>