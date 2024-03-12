
<?php
include "../inc/dbinfo.inc";

/* Connect to MySQL and select the database. */
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

$database = mysqli_select_db($connection, DB_DATABASE);

/* Ensure that the EMPLOYEES table exists. */
VerifyEmployeesTable($connection, DB_DATABASE);

/* If input fields are populated, add a row to the EMPLOYEES table. */
$employee_name = htmlentities($_POST['NAME']);
$employee_address = htmlentities($_POST['ADDRESS']);
$employee_age = htmlentities($_POST['AGE']);
$employee_birthdate = htmlentities($_POST['BIRTHDATE']);
$employee_department = htmlentities($_POST['DEPARTMENT']);
$employee_salary = htmlentities($_POST['SALARY']);

if (strlen($employee_name) || strlen($employee_address) || strlen($employee_age)) {
  AddEmployee($connection, $employee_name, $employee_address, $employee_age, $employee_birthdate, $employee_department, $employee_salary);
}
?>

<html>
<head>
  <title>Sample page</title>
  <script>
    function toggleDarkMode() {
      var body = document.body;
      body.classList.toggle("dark-mode");
    }
  </script>
  <style>
    .dark-mode {
      background-color: #333;
      color: blue;
    }
    .dark-mode input[type="text"], .dark-mode input[type="date"], .dark-mode input[type="number"], .dark-mode select {
      background-color: #444;
      color: blue;
    }
    .dark-mode button {
      background-color: #444;
      color: blue;
    }
    .dark-mode .add-data-button {
      color: black;
    }
    .dark-mode td {
      color: blue;
    }
  </style>
</head>
<body>

<h1>Sample page</h1>

<button onclick="toggleDarkMode()">Toggle Dark Mode</button>

<form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
  <table border="0">
    <tr>
      <td style="color: blue;">NAME</td>
      <td style="color: blue;">ADDRESS</td>
      <td style="color: blue;">AGE</td>
      <td style="color: blue;">BIRTHDATE</td>
      <td style="color: blue;">DEPARTMENT</td>
      <td style="color: blue;">SALARY</td>
    </tr>
    <tr>
      <td><input type="text" name="NAME" maxlength="45" size="30" /></td>
      <td><input type="text" name="ADDRESS" maxlength="90" size="60" /></td>
      <td><input type="text" name="AGE" maxlength="3" size="5" /></td>
      <td><input type="date" name="BIRTHDATE" size="30" /></td>
      <td>
        <select name="DEPARTMENT">
          <option value="Tech">Tech</option>
          <option value="Marketing">Marketing</option>
          <option value="RH">RH</option>
          <option value="Business">Business</option>
        </select>
      </td>
      <td><input type="number" name="SALARY" step="0.01" size="10" /></td>
      <td><input type="submit" value="Add Data" class="add-data-button" /></td>
    </tr>
  </table>
</form>

<table border="1" cellpadding="2" cellspacing="2">
  <tr>
    <td>ID</td>
    <td>NAME</td>
    <td>ADDRESS</td>
    <td>AGE</td>
    <td>BIRTHDATE</td>
    <td>DEPARTMENT</td>
    <td>SALARY</td>
  </tr>

<?php
$result = mysqli_query($connection, "SELECT * FROM EMPLOYEES");

while ($query_data = mysqli_fetch_row($result)) {
  echo "<tr>";
  echo "<td>", $query_data[0], "</td>",
       "<td>", $query_data[1], "</td>",
       "<td>", $query_data[2], "</td>",
       "<td>", $query_data[3], "</td>",
       "<td>", $query_data[4], "</td>",
       "<td>", $query_data[5], "</td>",
       "<td>", $query_data[6], "</td>";
  echo "</tr>";
}
?>
</table>

<?php
mysqli_free_result($result);
mysqli_close($connection);
?>

</body>
</html>

<?php
function AddEmployee($connection, $name, $address, $age, $birthdate, $department, $salary) {
  $n = mysqli_real_escape_string($connection, $name);
  $a = mysqli_real_escape_string($connection, $address);
  $age = intval($age);
  $b = mysqli_real_escape_string($connection, $birthdate);
  $d = mysqli_real_escape_string($connection, $department);
  $s = mysqli_real_escape_string($connection, $salary);

  $query = "INSERT INTO EMPLOYEES (NAME, ADDRESS, AGE, BIRTHDATE, DEPARTMENT, SALARY) VALUES ('$n', '$a', $age, '$b', '$d', $s);";

  if (!mysqli_query($connection, $query)) echo("<p>Error adding employee data.</p>");
}

function VerifyEmployeesTable($connection, $dbName) {
  if (!TableExists("EMPLOYEES", $connection, $dbName)) {
    $query = "CREATE TABLE EMPLOYEES (
        ID int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        NAME VARCHAR(45),
        ADDRESS VARCHAR(90),
        AGE INT(3),
        BIRTHDATE DATE,
        DEPARTMENT ENUM('Tech', 'Marketing', 'RH', 'Business'),
        SALARY DECIMAL(10, 2)
      )";

    if (!mysqli_query($connection, $query)) echo("<p>Error creating table.</p>");
  }
}

function TableExists($tableName, $connection, $dbName) {
  $t = mysqli_real_escape_string($connection, $tableName);
  $d = mysqli_real_escape_string($connection, $dbName);

  $checktable = mysqli_query($connection,
      "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_NAME = '$t' AND TABLE_SCHEMA = '$d'");

  if (mysqli_num_rows($checktable) > 0) return true;

  return false;
}
?>

## Máquinas

Para melhor visualizar a execução das máquinas virtuais, acesse o vídeo abaixo:

