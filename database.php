<!-- tes -->
<?php
    $conn = new mysqli("localhost","root","","photo_studio");

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
        if (empty($datetime) || $datetime === null) {
            return 'New';
        }
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


    function insbook($data) {
    global $conn;
    $id_user = $_SESSION['id_user'];
    $id_service = htmlspecialchars($data['service']);
    $booking_date = htmlspecialchars($data['schedule']);
    $booking_time = htmlspecialchars($data['time']);

    $query = "INSERT INTO bookings (id_user, id_service, booking_date, booking_time, status, created_at, updated_at)
              VALUES ('$id_user', '$id_service', '$booking_date', '$booking_time', 'pending', NOW(), NOW())";
    
    return mysqli_query($conn, $query);
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
    function hapus_Gall($id){
        GLOBAL $conn;
        mysqli_query($conn,"DELETE FROM gallery WHERE id_gallery = $id");
        return mysqli_affected_rows($conn);
    }


    // Ambil semua booking
    function getAllBookings() {
        global $conn;
        $query = "SELECT b.*, u.name as client_name, s.name as service_name 
                FROM bookings b 
                JOIN users u ON b.id_user = u.id_user
                JOIN services s ON b.id_service = s.id_service
                ORDER BY b.booking_date, b.booking_time";
        $result = mysqli_query($conn, $query);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    // Ambil booking dengan status pending
    function getPendingBookings() {
        $all = getAllBookings();
        return array_filter($all, fn($b) => $b['status'] === 'pending');
    }

    // Update status booking
    function updateBookingStatus($id_booking, $status) {
        global $conn;
        $status = mysqli_real_escape_string($conn, $status);
        $id_booking = mysqli_real_escape_string($conn, $id_booking);

        $query = "UPDATE bookings SET status='$status' WHERE id_booking='$id_booking'";
        mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);
    }

    // Cek jadwal bentrok (hanya pending)
    function getBentrokDates() {
        $pending = getPendingBookings();
        $bentrok = [];
        foreach ($pending as $p1) {
            foreach ($pending as $p2) {
                if ($p1['id_booking'] != $p2['id_booking'] &&
                    $p1['booking_date'] === $p2['booking_date'] &&
                    $p1['booking_time'] === $p2['booking_time']) {
                    $bentrok[] = $p1['booking_date'] . ' ' . $p1['booking_time'];
                }
            }
        }
        return array_unique($bentrok);
    }

    function tambahFile($data){
        global $conn;
        $category = strtolower($data["category"]);
        
        $picture = upload();
        if (!$picture) {
            return false;
        }

        $query = "INSERT INTO gallery(category,image_url) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ss", $category, $picture);
        mysqli_stmt_execute($stmt);
        return mysqli_affected_rows($conn);
    }

    function upload(){
    $name = $_FILES['picture']['name'];
    $size = $_FILES['picture']['size'];
    $error = $_FILES['picture']['error'];
    $temp = $_FILES['picture']['tmp_name'];

    if ($error === 4) {
        echo "<script>alert('Pilih gambar terlebih dahulu')</script>";
        return false;
    }

    $formatGambar = ['jpg','jpeg','png'];
    $namaGambar = strtolower(pathinfo($name, PATHINFO_EXTENSION));

    if (!in_array($namaGambar, $formatGambar)) {
        echo "<script>alert('Yang anda upload bukan gambar!')</script>";
        return false;
    }

    if ($size > 2 * 1024 * 1024) {
        echo "<script>alert('Ukuran gambar terlalu besar! Maksimal 2MB')</script>";
        return false;
    }

    $nameGenerate = uniqid('img_', true) . '.' . $namaGambar;

    $uploadDir = __DIR__ . '/img/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (move_uploaded_file($temp, $uploadDir . $nameGenerate)) {
        return $nameGenerate;
    } else {
        echo "<script>alert('Gagal memindahkan file. Periksa folder img dan permissionnya.')</script>";
        return false;
    }
}


?>
