<?php
if (isset($_POST['submit'])) {
    $result = $_POST['physics'] + $_POST['chemistry'] + $_POST['biology'] + $_POST['mathematics'] + $_POST['computer'];
    switch ($result) {
        case $result >= 90:
            $grade = 'A';
            break;

        case $result >= 80:
            $grade = 'B';
            break;
        case $result >= 70:
            $grade = 'C';
            break;
        case $result >= 60:
            $grade = 'D';
            break;
        case $result >= 40:
            $grade = 'E';
            break;
        case $result < 40:
            $grade = 'F';
            break;
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>calc grade</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="css/1.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <form method="POST">
        <h1>calc grade Form</h1>
        <div class="formcontainer">
            <hr />
            <div class="container">
                <label for="physics"><strong>Physics</strong></label>
                <input type="number" placeholder="Enter Your Physics degree" name="physics" required>

                <label for="chemistry"><strong>Chemistry</strong></label>
                <input type="number" placeholder="Enter Your Chemistry degree" name="chemistry" required>

                <label for="biology"><strong>Biology</strong></label>
                <input type="number" placeholder="Enter Your Biology degree" name="biology" required>

                <label for="mathematics"><strong>Mathematics</strong></label>
                <input type="number" placeholder="Enter Your Mathematics degree" name="mathematics" required>

                <label for="computer"><strong>Computer</strong></label>
                <input type="number" placeholder="Enter Your Computer degree" name="computer" required>
            </div>
            <button name="submit" type="submit">CALC</button>
    </form>
    <?php
    if (isset($grade)) {
        echo '<table class="table">
        <tbody>
        <tr>
        <th>Your Grade Is </th>
<td>' . $grade . '</td>

        </tr></tbody>
        </table>';
    }
    ?>
</body>

</html>