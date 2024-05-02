<?php
session_start();

$userId = $_GET['userId'];

?>
<script>
    
    function registrationcar(PlateID, PricePerDay, OfficeID) {
        var pickDate = document.getElementById("pickDate").value;
        var returnDate = document.getElementById("returnDate").value;
        if (pickDate > returnDate){
            alert("Password is required");
            return false;
        }
        return true;
}

</script>
<html>
    <head>
    <title>Home Page</title>
    <link rel="stylesheet" type="text/css" href="reserStyle.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Option</title>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var urlParams = new URLSearchParams(window.location.search);
            var variableValue = urlParams.get('variableName');
            console.log(variableValue);
        });
    </script>
    </head>
    <body>
        <div class="wrapper">
            <div class="form-wrapper options">
                <form name="user_options" method="post" action="reservation.php" onsubmit="return validateregistration();">
                    <h2>Car reservation</h2>
                    <input type="hidden" name="userId" value="<?php echo $userId; ?>">
                    <div class="input-group">
                        <label>Model</label>
                        <input name="modelName" id="modelName" type="text">
                    </div>
                    <div class="input-group">
                        <label>Year</label>
                        <select name="year" id="year">
                            <option value=""></option>
                            <option value="2000">2000</option>
                            <option value="2001">2001</option>
                            <option value="2002">2002</option>
                            <option value="2003">2003</option>
                            <option value="2004">2004</option>
                            <option value="2005">2005</option>
                            <option value="2006">2006</option>
                            <option value="2007">2007</option>
                            <option value="2008">2008</option>
                            <option value="2009">2009</option>
                            <option value="2010">2010</option>
                            <option value="2011">2011</option>
                            <option value="2012">2012</option>
                            <option value="2013">2013</option>
                            <option value="2014">2014</option>
                            <option value="2015">2015</option>
                            <option value="2016">2016</option>
                            <option value="2017">2017</option>
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <!-- Add more options as needed -->
                        </select>
                    </div>
                    <div class="input-group">
                        <label>Number of passengers</label>
                        <select name="passengerCount" id="passengerCount">
                            <option value=""></option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <!-- Add more options as needed -->
                        </select>
                    </div>
                    <div class="input-group">
                        <label>Office location</label>
                        <select name="officeLocation" id="officeLocation">
                            <option value=""></option>
                            <option value="Downtown Office">Downtown Office</option>
                            <option value="Suburb Office">Suburb Office</option>
                            <option value="Airport Office">Airport Office</option>
                            <!-- Add more options as needed -->
                        </select>
                    </div>
                    <div class="input-group">
                        <label for="datepicker">Select Pick-up Date:</label>
                        <input type="date" id="pickDate" name="pickDate">
                    </div>
                    <div class="input-group">
                        <label for="datepicker">Select Return Date:</label>
                        <input type="date" id="returnDate" name="returnDate">
                    </div>
                    
                        <button type="submit">Search</button>
                </form>
            </div>
        </div>
    </body>
</html>