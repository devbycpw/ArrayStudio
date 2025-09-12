<?php
    $conn = new mysqli("localhost","root","","latihan2");

    if ($conn -> connect_errno){
        echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
        exit();
    }

    function query($query){
        GLOBAL $conn;
        $result = mysqli_query($conn, $query);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }
        return $rows;
    }

    function timeAgo($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = [
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        ];
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    function insbook($data){
        global $conn;
        $id_user = $_SESSION['id_user'];
        $id_service = $data['service'];
        $schedule = $data['schedule'];
        $status = "pending";

        $query = "INSERT INTO bookings (id_user, id_service, booking_date, status, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "iiss", $id_user, $id_service, $schedule, $status);
        mysqli_stmt_execute($stmt);
        
        return mysqli_affected_rows($conn);
    }   

    function register($data){
        global $conn;

        $username = strtolower(stripslashes($data['username']));
        $email = mysqli_real_escape_string($conn, $data['email']);
        $password = mysqli_real_escape_string($conn, $data['password']);
        $konfirmasi = mysqli_real_escape_string($conn, $data['konfirmasi']);
        $role = 'client';

        $result = mysqli_query($conn, "SELECT name FROM users WHERE name = '$username' OR email = '$email'");
        
        if (mysqli_fetch_assoc($result)) {
            echo "<script>
                alert('username dan email sudah terdaftar');
            </script>";
            return false;
        }
        
        if ($password !== $konfirmasi) {
            echo"<script>
                alert('konfirmasi password tidak sesuai');
            </script>";
            return false;
        }

        $password = password_hash($password, PASSWORD_DEFAULT);
        $user = "INSERT INTO users(name,email,password,role) VALUES ('$username', '$email', '$password', '$role')";
        mysqli_query($conn, $user);
        return mysqli_affected_rows($conn);
    }
    
    function tambah($data){
    global $conn;
    $name = htmlspecialchars($data["name"]);
    $description = htmlspecialchars($data["description"]);
    $price = htmlspecialchars($data["price"]);

    // prepared statement
    $stmt = mysqli_prepare($conn, "INSERT INTO services(name, description, price) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssd", $name, $description, $price); 

    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt);
}

    function edit($data){
        global $conn;
        $id = $data["id_service"];
        $name = htmlspecialchars($data["name"]);
        $description = htmlspecialchars($data["description"]);
        $price = htmlspecialchars($data["price"]);

        $query = "UPDATE services SET name='$name', description = '$description', price='$price' WHERE id_service = $id";
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);

    }

    function hapus($id){
        GLOBAL $conn;
        mysqli_query($conn,"DELETE FROM services WHERE id_service = $id");
        return mysqli_affected_rows($conn);
    }
?>
