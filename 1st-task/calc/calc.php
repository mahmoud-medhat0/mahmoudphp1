<?php
if (isset($_POST['submit'])) {
    switch ($_POST['submit']) {
        case '+':
            $result = $_POST['fnum'] + $_POST['snum'];
            break;
        case '-':
            $result = $_POST['fnum'] - $_POST['snum'];
            break;
        case '*':
            $result = $_POST['fnum'] * $_POST['snum'];
            break;
        case '/':
            $result = $_POST['fnum'] / $_POST['snum'];
            break;
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Calculator</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="css/1.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <form method="POST">
        <h1>Simple Calculator</h1>
        <div class="formcontainer">
            <hr />
            <div class="container">
                <label for="fnum"><strong>Physics</strong></label>
                <input type="number" placeholder="Enter First Number" name="fnum" required>

                <label for="snum"><strong>Chemistry</strong></label>
                <input type="number" placeholder="Enter Second Number" name="snum" required>
            </div>
            <input name="submit" value="+" type="submit">
            <input name="submit" value="-" type="submit">
            <input name="submit" value="*" type="submit">
            <input name="submit" value="/" type="submit">
    </form>
    <?php
    if (isset($result)) {
        echo '<table class="table">
        <tbody>
        <tr>
        <th>The Output Is </th>
<td>' . $result . '</td>

        </tr></tbody>
        </table>';
    }
    ?>
</body>

</html>