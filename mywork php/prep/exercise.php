<html>
    <head>
        <title>login form</title>
    </head>
    <body>
        
       <form method="POST" action="">
         <input type="" name="phone_number" placehoder="enter ur phone number"><br><br>
        <input type="text" name="firstname" placehoder="    ur first name"><br><br>
          <input type="text" name="lastname" placehoder="    ur lastname"><br><br>
            <select name="gender">
                <option value="female">female</option>
                <option value="male">male</option>
            </select><br><br>
            <select name="province" id="">
                <option value="province">east</option>
                <option value="province">west</option>
                <option value="province">north</option>
                <option value="province">south</option>
                <option value="province">kigali </option>
            </select>
            <button name="submit">sent</button><br><br>
       </form>
    </body>
</html>

<?php
$conn=new (mysqli_connect("localhost","root","","classA"));
if(isset($_POST["submit"])){
    $phone=$_POST["phone_number"];
    $fname=$_POST["firstname"];
    $lname=$_POST["lastname"];
    $gender=$_POST['gender'];
    $pro=$_POST["province"];

    $ins=$conn->query("insert into information set phone_number='$phone', firstname='$fname',lastname='$lname',gender='$gender',province='$pro'");
if($ins){
    echo"data inserted successfully😂😂😂";
}
else{
    echo"isn't working buddy try again😂😂😂";
}

}





?>
