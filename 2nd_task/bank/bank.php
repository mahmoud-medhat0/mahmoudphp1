<?php
if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $salery = $_POST['salery'];
    $numy = $_POST['numy'];
    if($numy<=3){
        $precent=10;
        $payreq= $salery*($precent/100)+$salery;
    }elseif($numy>3){
        $precent=15;
        $payreq= $salery*($precent/100)+$salery;
    }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Simple login form</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="css/1.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
    <form method="POST">
      <h1>Loan Form</h1>
      <div class="formcontainer">
      <hr/>
      <div class="container">
        <label for="name"><strong>Name</strong></label>
        <input type="text" placeholder="Enter Yourname" name="name" required>
        <label for="salery"><strong>salery</strong></label>
        <input type="number" placeholder="Enter Value of Loan" name="salery" required>
        <label for="numy"><strong>Number Of Years To Be Paid</strong></label>
        <input type="number" placeholder="Enter Number Of Years" name="numy" required>
      </div>
      <button name="submit" type="submit">SUBMIT</button>
    </form>
    <?php
    if (isset($payreq)){
        echo '<table class="table">
        <tbody>
        <tr>
        <th>Name</th>
<td>'.$name.'</td>
<th>the cost of mony</th>
<td>'.$salery.'</td>
<th>precentage of benefit</th>
<td>'.$precent."%".'</td>
<th>the cost after benefit</th>
<td>'.$payreq.'</td>
        </tr></tbody>
        </table>';
    }
    ?>
  </body>
</html>