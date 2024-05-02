<html>
<head>
  <title>Home Page</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <script>
    function validatelogin() {
    var email = document.getElementById("logemail").value;
    var password = document.getElementById("logpass").value;

    if(email == null || email == "") {
        alert("Email is required");
        return false;
    }
    if(password == null || password =="") {
        alert("Password is required");
        return false;
    }
    var emailvalid = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
    if(email.search(emailvalid)== -1) {
        alert("Invalid Email Address");
        return false;
    }
    return true;   
}

function validateregistration() {
        var name = document.getElementById("uname").value;
        var NaID = document.getElementById("nid").value;
        var phnum = document.getElementById("pnum").value;
        var age = document.getElementById("age").value;
        var email = document.getElementById("regemail").value;
        var password = document.getElementById("regpass").value;
        var confirmPassword = document.getElementById("confpass").value;

        if(name == null || name == "") {
            alert("Username is required");
            return false;
        }
        if(NaID == null || NaID == "") {
            alert("National ID is required");
            return false;
        }
        if(phnum == null || phnum == "") {
            alert("Phone Number is required");
            return false;
        }
        if(age == null || age =="") {
            alert("Age is required");
            return false;
        }
        if(email == null || email == "") {
            alert("Email is required");
            return false;
        }
        if(password == null || password =="") {
            alert("Password is required");
            return false;
        }
        if(confirmPassword == null || confirmPassword =="") {
            alert("Confirm Password is required");
            return false;
        }
        if(password != confirmPassword) {
            alert("Confirm Password doesn't match your Password");
            return false;
        }
        var emailvalid = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
        if(email.search(emailvalid)== -1) {
            alert("Invalid Email Address");
            return false;
        }
        return true;   
    }

    function errorMessage() {
      setTimeout(function () {
        alert("Incorrect Email or Password");
    }, 5000);
  }
    function existEmail() {
      setTimeout(function () {
        console.log("Error message function called");
            alert("This Email already exists!");
    }, 50);
    }

</script>
</head>
<body>

<?php
$mysql = new mysqli('localhost', 'root', '', 'car_rental_system');
if ($mysql->connect_errno) {
    echo"Failed to connect". $mysql->connect_error;
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["name"])) {
    $name = $_POST["name"];
    $nationalID = $_POST["nationalID"];
    $phoneNumber = $_POST["pnum"];
    $age = $_POST["age"];
    $email = $_POST["regemail"];
    $password = $_POST["password"];
    $passencrypted = md5($password);

    $query1 = "SELECT * FROM customer WHERE email= '$email'";

    $result1 = $mysql->query($query1);
    if ($result1->num_rows > 0) {
        echo "<script>existEmail();</script>";
        header("Location: login.php");
    }
    else {
        $query3 = "INSERT INTO customer(CustomerID, CustomerName, TelephoneNumber, Age, Email, Password) VALUES ('$nationalID', '$name', '$phoneNumber', '$age', '$email', '$passencrypted')";
        if ($mysql->query($query3)) {
          session_start();
          $query2 = " SELECT CustomerID FROM customer WHERE Email = '$email' ";
          $result2 = $mysql->query($query2);
         
        if ($result2) {
            $row = $result2->fetch_assoc();
            $_SESSION['userId'] = $row['CustomerID'];
            header("Location: userOption.php");
          } else {
              echo "Query error: " . $mysql->error;
          }
        }
        else {
            echo "ERROR HAPPENED".$mysql->error;
        }
    }
}
    else {
        $email = $_POST["email"];
        $password = md5($_POST["password"]);

        $query1 = "SELECT * FROM customer WHERE Email = '$email' AND Password = '$password'";
        $result1 = $mysql->query($query1);
        
        if ($result1->num_rows > 0) {
            session_start();
            $query2 = " SELECT CustomerID FROM customer WHERE Email = '$email' ";
            $result2 = $mysql->query($query2);
            if ($result2) {
              $row = $result2->fetch_assoc();
              $_SESSION['userId'] = $row['CustomerID'];
              header("Location: userOption.php");
            } else {
                echo "Query error: " . $mysql->error;
            }
              
          }
          else {
              
              echo "<script>errorMessage();</script>";
              header("Location: login.php");
  
          }
        
    }
}

$mysql->close();
?>

  <div class="wrapper">
    <div class="form-wrapper sign-in">
      <form name="loform" method="post" onsubmit="return validatelogin();">
        <h2>Login</h2>
        <div class="input-group">
          <input name="email" id="logemail" type="text">
          <label>Email</label>
        </div>
        <div class="input-group">
          <input name="password" id="logpass" type="password">
          <label>Password</label>
        </div>
        <button type="submit">Login</button>
        <div class="signUp-link">
          <p>Don't have an account? <a href="#" class="signUpBtn-link">Register</a></p>
        </div>
      </form>
    </div>
    <div class="form-wrapper sign-up">
      <form name="reform" method="post" onsubmit="return validateregistration();">
        <h2>Registration</h2>
        <div class="input-group">
          <input name="name" id="uname" type="text">
          <label>Name</label>
        </div>
        <div class="input-group">
          <input name="nationalID" id="nid" type="text">
          <label>National ID</label>
        </div>
        <div class="input-group">
          <input name="pnum" id="pnum" type="text">
          <label>Phone Number</label>
        </div>
        <div class="input-group">
          <input name="age" id="age" type="text">
          <label>Age</label>
        </div>
        <div class="input-group">
          <input name="regemail" id="regemail" type="text">
          <label>Email</label>
        </div>
        <div class="input-group">
          <input  name="password" id="regpass" type="password">
          <label>Password</label>
        </div>
        <div class="input-group">
          <input name="confirmpassword" id="confpass" type="password">
          <label>Confirm Password</label>
          <div class="error"></div>
        </div>
        <button type="submit">Sign Up</button>
        <div class="signUp-link">
          <p>Already have an account? <a href="#" class="signInBtn-link">LogIn</a></p>
        </div>
      </form>
    </div>
  </div>
  <script src="tran.js"></script>
</body>
</html>