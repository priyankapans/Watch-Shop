<?php
session_start();
if(isset($_SESSION["loggedInUserEmail"])) {
    $email = $_SESSION["loggedInUserEmail"];
	
//Connect to MongoDB
$mongoClient = new MongoClient();

//Select a database
$db = $mongoClient->ecommerce;

echo "<center> <h1> $email past orders </h1> </center>";

$findCriteria = [
       "email" => $email,

];

$Val = $db->orders->find($findCriteria);


echo"<h1>Result</h1>";

if($Val->count() > 0){
            echo '<table>';
            echo '<tr><th>Order ID</th><th>Customer ID</th><th>Customer email</th><th>Product name</th><th>Count</th><th>Price</th></tr>';
            foreach ($Val as $ord) {
                echo '<tr>';
				echo '<td>' . $ord["orderID"] . "</td>";
				echo '<td>' . $ord["customerID"] . "</td>";
                echo '<td>' . $ord["email"] . "</td>";
				foreach ($ord["products"] as $pro) {
					
                echo '<td>' . $pro["name"] . "</td>";
				echo '<td>' . $pro["count"] . "</td>";
				}
                echo '</tr>';
            }
            echo '</table>';
}
else{
	echo"Cannot find order";
}

//Close the connection
$mongoClient->close();
}else {
	echo "<h1> Please login to access the settings page </h1>";
	
	header('Refresh: 3, url = /loginPage.php');
}



?>