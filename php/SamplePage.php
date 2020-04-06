<?php include "../inc/dbinfo.inc"; ?>
<?php
  /* Connect to MySQL and select the database. */
  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
  if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

 

  $database = mysqli_select_db($connection, DB_DATABASE);

 

  /* Ensure that the EMPLOYEES table exists. */
  #VerifyEmployeesTable($connection, DB_DATABASE);
  /* If input fields are populated, add a row to the EMPLOYEES table. */
  $fullname = htmlentities($_POST['fullname']);
  $email = htmlentities($_POST['email']);
  $message = htmlentities($_POST['message']);
  if (strlen($fullname) || strlen($email) || strlen($message))) {
    AddFeedBack($connection, $fullname, $email, $message);
  }

 

/* $result = mysqli_query($connection, "SELECT * FROM EMPLOYEES");

 

while($query_data = mysqli_fetch_row($result)) {
  echo "<tr>";
  echo "<td>",$query_data[0], "</td>",
       "<td>",$query_data[1], "</td>",
       "<td>",$query_data[2], "</td>";
  echo "</tr>";
}
 */  mysqli_free_result($result);
  mysqli_close($connection);

 

/* Add an employee to the table. */
function AddFeedBack($connection, $fullname, $email, $message) {
   $_fullname = mysqli_real_escape_string($connection, $fullname);
   $_email = mysqli_real_escape_string($connection, $email);
   $_message = mysqli_real_escape_string($connection, $message);

 

   $query = "INSERT INTO Feedback (fullname, email, message) VALUES ('$_fullname', '$_email', '$_message);";
   if(!mysqli_query($connection, $query)) echo("<p>Error adding feedback.</p>");
}

/* Check whether the table exists and, if not, create it. */
function VerifyEmployeesTable($connection, $dbName) {
  if(!TableExists("EMPLOYEES", $connection, $dbName))
  {
     $query = "CREATE TABLE EMPLOYEES (
         ID int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
         NAME VARCHAR(45),
         ADDRESS VARCHAR(90)
       )";

 

 

 

     if(!mysqli_query($connection, $query)) echo("<p>Error creating table.</p>");
  }
}

 

 

 

/* Check for the existence of a table. */
function TableExists($tableName, $connection, $dbName) {
  $t = mysqli_real_escape_string($connection, $tableName);
  $d = mysqli_real_escape_string($connection, $dbName);

 

 

 

  $checktable = mysqli_query($connection,
      "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_NAME = '$t' AND TABLE_SCHEMA = '$d'");

 

 

 

  if(mysqli_num_rows($checktable) > 0) return true;

 

 

 

  return false;
}
?>