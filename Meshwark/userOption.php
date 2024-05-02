<?php
session_start();

$userId = $_SESSION['userId'];

?>
<html>
    <head>
    <title>Home Page</title>
    <link rel="stylesheet" type="text/css" href="optionStyle.css">
    </head>
    <body>
        <div class="wrapper">
            <div class="form-wrapper options">
                <form name="user_options" method="post" onsubmit="return false;">
                    <h2>Customer options</h2>
                        <button type="submit" onclick="navigateTo('carReservation.php?userId=<?php echo $userId; ?>')">Car reservation</button>
                        <button type="submit" onclick="navigateTo('History.php?userId=<?php echo $userId; ?>')">History and Information</button>
                </form>
            </div>
        </div>
        <script>
            function navigateTo(page) {
                window.location.href = page;
            }
        </script>
    </body>
</html>