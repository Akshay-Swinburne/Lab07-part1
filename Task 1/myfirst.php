<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "utf-8">
    <title>Using PHP Variables, arrays, and operators</title>
    <!--add other meta-->
</head>
<body>
    <h1>PHP Variables, arrays, and operators</h1>
<?php
    $marks = array (85, 85, 95); // declare and initialise array
    $marks[1] = 90; // modify second element
    $ave = ($marks[0] + $marks[1] + $marks[2])/3;  //Compute Average
    if($ave >= 50)
        $status = "PASSED";
    else
        $status = "FAILED";
    echo "<p>The average score is $ave. You $status.</p>";
?>

</body>
</html>