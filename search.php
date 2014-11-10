<html>
<head>
<Title>Search the database</Title>
<style type="text/css">
    body { background-color: #fff; border-top: solid 10px #000;
        color: #333; font-size: .85em; margin: 20; padding: 20;
        font-family: "Segoe UI", Verdana, Helvetica, Sans-Serif;
    }
    h1, h2, h3,{ color: #000; margin-bottom: 0; padding-bottom: 0; }
    h1 { font-size: 2em; }
    h2 { font-size: 1.75em; }
    h3 { font-size: 1.2em; }
    table { margin-top: 0.75em; }
    th { font-size: 1.2em; text-align: left; border: none; padding-left: 0; }
    td { padding: 0.25em 2em 0.25em 0em; border: 0 none; }
</style>
</head>
<body>
<h1>Search here!</h1>
<a href="index.php"><h3>or click here to register</h3></a>
<p>Fill in any of the details of the person you are looking for, then click <strong>Search</strong> to search the database.</p>
<form method="post" action="search.php" enctype="multipart/form-data" >
      Name  <input type="text" name="name" id="name"/></br>
      Email <input type="text" name="email" id="email"/></br>
      Company Name <input type="text" name="company" id="company"/></br>
      <input type="submit" name="search" value="Search" />
</form>
<?php
    // DB connection info
    $host = "eu-cdbr-azure-north-b.cloudapp.net";
    $user = "bd4d05ca2e254d";
    $pwd = "9200243b";
    $db = "cw2tutoAFHWN3BCc";
    // Connect to database.
    try {
        $conn = new PDO( "mysql:host=$host;dbname=$db", $user, $pwd);
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
    catch(Exception $e){
        die(var_dump($e));
    }
    // Insert registration info
    if(!empty($_POST)) {
    try {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $company = $_POST['company'];
    }
    catch(Exception $e) {
        die(var_dump($e));
    }
    }
    // Retrieve data
    $sql_select = "SELECT * FROM registration_tbl 
                   WHERE (name LIKE '%{$name}%' OR '$name' = '')
                   AND (email LIKE '%{$email}%' OR '$email' = '')
                   AND (company LIKE '%{$company}%' OR '$company' = '')";
    $stmt = $conn->query($sql_select);
    $registrants = $stmt->fetchAll(); 
    if(count($registrants) > 0) {
        echo "<h2>People who are registered:</h2>";
        echo "<table>";
        echo "<tr><th>Name</th>";
        echo "<th>Email</th>";
        echo "<th>Company Name</th>";
        echo "<th>Date</th></tr>";
        foreach($registrants as $registrant) {
            echo "<tr><td>".$registrant['name']."</td>";
            echo "<td>".$registrant['email']."</td>";
            echo "<td>".$registrant['company']."</td>";
            echo "<td>".$registrant['date']."</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<h3>No one with those details is currently registered.</h3>";
    }
?>
</body>
</html>