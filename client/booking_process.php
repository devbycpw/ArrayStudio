<?php
    require '../database.php';
    require '../layouts/main.php';
    include '../layouts/navbarClient.php';
?>



<?php
require 'database.php';

$user_id = $_SESSION['login'];
$name        = $_POST['name'];
$service_id  = $_POST['service_id'];
$booking_date = $_POST['booking_date'];

$query = "INSERT INTO bookings (user_id, service_id, booking_date) 
          VALUES ('$user_id', '$service_id', '$booking_date')";

if (mysqli_query($conn, $query)) {
    echo "Booking berhasil! <a href='services.php'>Kembali</a>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>



    
    
<?php    
    include '../layouts/footer.php'
?>