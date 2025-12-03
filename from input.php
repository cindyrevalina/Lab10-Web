<?php
// C:\xampp\htdocs\lab10_php_oop\form_input.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Koneksi database langsung
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'latihan1';

$conn = new mysqli($host, $user, $pass, $dbname);

// Proses form jika ada POST
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['txtnim'])) {
    $nim = $_POST['txtnim'];
    $nama = $_POST['txtnama'];
    $alamat = $_POST['txtalamat'];
    
    if (!empty($nim) && !empty($nama) && !empty($alamat)) {
        if ($conn->connect_error) {
            $message = "<div style='color: red; padding: 10px;'>Database error!</div>";
        } else {
            // Insert data
            $sql = "INSERT INTO users (nim, nama, alamat) VALUES ('$nim', '$nama', '$alamat')";
            if ($conn->query($sql)) {
                $message = "<div style='color: green; padding: 10px;'>✅ Data berhasil disimpan!</div>";
            } else {
                $message = "<div style='color: orange; padding: 10px;'>Gagal: " . $conn->error . "</div>";
            }
        }
    } else {
        $message = "<div style='color: red; padding: 10px;'>❌ Semua field harus diisi!</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Form Input - Praktikum 10</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Form Input Data Mahasiswa</h2>
        
        <?php echo $message; ?>
        
        <?php
        // Gunakan class Form dari lib/form.php jika ada
        if (file_exists('lib/form.php')) {
            include_once 'lib/form.php';
            $form = new Form('', 'Input Form');
            $form->addField('txtnim', 'NIM');
            $form->addField('txtnama', 'Nama');
            $form->addField('txtalamat', 'Alamat');
            $form->displayForm();
        } else {
            // Jika class Form tidak ada, tampilkan form manual
            echo '<form method="POST">';
            echo '<table>';
            echo '<tr><td>NIM:</td><td><input type="text" name="txtnim"></td></tr>';
            echo '<tr><td>Nama:</td><td><input type="text" name="txtnama"></td></tr>';
            echo '<tr><td>Alamat:</td><td><input type="text" name="txtalamat"></td></tr>';
            echo '<tr><td colspan="2"><input type="submit" value="Simpan"></td></tr>';
            echo '</table>';
            echo '</form>';
        }
        
        // Tampilkan data jika ada koneksi
        if ($conn && !$conn->connect_error) {
            $result = $conn->query("SELECT * FROM users ORDER BY id DESC LIMIT 5");
            if ($result->num_rows > 0) {
                echo '<h3>Data Terbaru:</h3>';
                echo '<table border="1">';
                echo '<tr><th>NIM</th><th>Nama</th><th>Alamat</th></tr>';
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row['nim'] . '</td>';
                    echo '<td>' . $row['nama'] . '</td>';
                    echo '<td>' . substr($row['alamat'], 0, 30) . '...</td>';
                    echo '</tr>';
                }
                echo '</table>';
            }
            $conn->close();
        }
        ?>
        
        <br>
        <a href="index.php">Kembali ke Home</a>
    </div>
</body>
</html>