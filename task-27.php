<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

// Konfigurasi database
$host = 'localhost';
$user = 'root';  // Username MySQL default
$pass = '';      // Password kosong (jika tidak ada)
$db = 'task-27';

// Koneksi ke database
$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mendapatkan data dari tabel orders
$sql = "SELECT order_id, order_date, name, price, quantity, total FROM orders";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Penting</title>
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
    }
    
    th, td {
      padding: 10px;
      text-align: left;
      border: 1px solid #ddd;
    }
    
    th {
      cursor: pointer;
      background-color: #4CAF50;
      color: white;
    }
    
    th:hover {
      background-color: #45a049;
    }

    .pagination {
      display: flex;
      justify-content: center;
      margin-top: 20px;
    }

    .pagination button {
      padding: 10px;
      margin: 0 5px;
      border: none;
      background-color: #f1f1f1;
      color: #333;
      cursor: pointer;
    }

    .pagination button.active {
      background-color: #4CAF50;
      color: white;
      cursor: default;
    }

    .pagination button:hover:not(.active) {
      background-color: #ddd;
    }

    .pagination button:disabled {
      background-color: #f1f1f1;
      color: #ccc;
      cursor: not-allowed;
    }

    /* CSS untuk tombol logout */
    .logout-button {
      display: inline-block;
      padding: 10px 20px;
      margin-top: 20px;
      background-color: #e74c3c; /* Warna merah */
      color: white;
      text-align: center;
      text-decoration: none;
      border-radius: 5px; /* Sudut membulat */
      transition: background-color 0.3s ease; /* Efek transisi */
    }

    .logout-button:hover {
      background-color: #c0392b; /* Warna lebih gelap saat hover */
    }

    .logout-button:active {
      background-color: #a93226; /* Warna saat ditekan */
    }
  </style>
</head>
<body>

<h2>Data Pesanan</h2>

<table>
  <thead>
    <tr>
      <th>ID Pesanan</th>
      <th>Tanggal Pesanan</th>
      <th>Nama Produk</th>
      <th>Harga</th>
      <th>Kuantitas</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if ($result->num_rows > 0) {
        // Output data dari setiap baris
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['order_id'] . "</td>";
            echo "<td>" . $row['order_date'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['price'] . "</td>";
            echo "<td>" . $row['quantity'] . "</td>";
            echo "<td>" . $row['total'] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6'>Tidak ada data pesanan</td></tr>";
    }
    ?>
  </tbody>
</table>

<!-- Mengubah link logout menjadi tombol dengan class logout-button -->
<a href="logout.php" class="logout-button">Logout</a>

</body>
</html>

<?php
$conn->close();
?>
