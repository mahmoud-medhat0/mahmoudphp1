<?php
include('includes/session.php');
$tr = ['Question', 'Rate'];
$questions = ['Do You Satisfied About Clean Level ?', 'Do You Satisfied on Servive Sales ?', 'Are you satisfied with the nursing service ?', 'Are you satisfied with the level of the doctor ?', 'Are you satisfied with the calmness in the hospital ?'];
$survey = ['super-happy', 'happy', 'neutral', 'sad'];
$rate0 = $_POST['rating0'];
$rate1 = $_POST['rating1'];
$rate2 = $_POST['rating2'];
$rate3 = $_POST['rating3'];
$rate4 = $_POST['rating4'];
switch ($rate0) {
    case 'super-happy0':
        $form0 = 10;
        break;

    case 'happy0':
        $form0 = 5;
        break;
    case 'neutral0':
        $form0 = 3;
        break;
    case 'sad0':
        $form0 = 0;
        break;
}

switch ($rate1) {
    case 'super-happy1':
        $form1 = 10;
        break;

    case 'happy1':
        $form1 = 5;
        break;
    case 'neutral1':
        $form1 = 3;
        break;
    case 'sad1':
        $form1 = 0;
        break;
}
switch ($rate2) {
    case 'super-happy2':
        $form2 = 10;
        break;

    case 'happy2':
        $form2 = 5;
        break;
    case 'neutral2':
        $form2 = 3;
        break;
    case 'sad2':
        $form2 = 0;
        break;
}
switch ($rate3) {
    case 'super-happy3':
        $form3 = 10;
        break;

    case 'happy3':
        $form3 = 5;
        break;
    case 'neutral3':
        $form3 = 3;
        break;
    case 'sad3':
        $form3 = 0;
        break;
}
switch ($rate4) {
    case 'super-happy4':
        $form4 = 10;
        break;

    case 'happy4':
        $form4 = 5;
        break;
    case 'neutral4':
        $form4 = 3;
        break;
    case 'sad4':
        $form4 = 0;
        break;
}
$form = [$form0, $form1, $form2, $form3, $form4];
$result = $form0 + $form1 + $form2 + $form3 + $form4;
if ($result<=25){
    $message='<td class="alert alert-danger" role="alert">
    We will call you later on this phone :'.$_SESSION['number'].'
  </td>';
}else{
    $message='<td class="alert alert-success" role="alert">
    Thanks For Your Time
  </td>';
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>result</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/1.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <div class="row">
        <div class="col-12">
            <table class="table">
                <thead class="thead-primary">
                    <tr>
                        <?php foreach ($tr as $thr) { ?>
                            <th col="col"><?= $thr; ?></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($questions as $index => $qq) { ?>
                        <tr>
                            <th scope="row">
                                <?= $qq ?>
                            </th>
                            <td>
                                <?php
                                echo $form[$index] . "<br>";
                                ?>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                    <tr>

                        <th>Result</th>
                        <td><?= $result ?></td>
                        <th>
                            
                        </th>
                        <tr>

                        <th>our message</th>
                        <?=$message?>
                        <th>
                            
                        </th>
                    </tr>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>