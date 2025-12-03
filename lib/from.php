<?php
// C:\xampp\htdocs\praktikum10\form.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Koneksi database langsung
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'latihan1';

$conn = new mysqli($host, $user, $pass, $dbname);

// Jika database belum ada, buat
if ($conn->connect_error) {
    echo "<div style='color: red; padding: 10px; border: 1px solid red;'>";
    echo "<h3>Database Error!</h3>";
    echo "Error: " . $conn->connect_error . "<br>";
    echo "Buat database dengan:<br>";
    echo "1. Buka http://localhost/phpmyadmin<br>";
    echo "2. Buat database 'latihan1'<br>";
    echo "3. Import SQL yang diberikan<br>";
    echo "</div>";
    $conn = null;
}

// Proses form jika ada POST
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nim'])) {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    
    if (!empty($nim) && !empty($nama) && !empty($alamat)) {
        if ($conn) {
            // Cek tabel users, jika tidak ada buat
            $checkTable = $conn->query("SHOW TABLES LIKE 'users'");
            if ($checkTable->num_rows == 0) {
                // Buat tabel users
                $createTable = "CREATE TABLE users (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    nim VARCHAR(20) NOT NULL UNIQUE,
                    nama VARCHAR(100) NOT NULL,
                    alamat TEXT NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )";
                $conn->query($createTable);
            }
            
            // Insert data
            $sql = "INSERT INTO users (nim, nama, alamat) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $nim, $nama, $alamat);
            
            if ($stmt->execute()) {
                $message = "<div style='color: green; padding: 10px; background: #d4edda; border-radius: 5px;'>
                    ✅ Data berhasil disimpan! NIM: $nim
                </div>";
            } else {
                $message = "<div style='color: #856404; padding: 10px; background: #fff3cd; border-radius: 5px;'>
                    ⚠️ Gagal: " . $conn->error . "
                </div>";
            }
        } else {
            $message = "<div style='color: orange; padding: 10px; background: #ffeaa7; border-radius: 5px;'>
                ⚠️ Database tidak terkoneksi. Data tidak disimpan.
            </div>";
        }
    } else {
        $message = "<div style='color: #721c24; padding: 10px; background: #f8d7da; border-radius: 5px;'>
            ❌ Semua field harus diisi!
        </div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Mahasiswa</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 500px;
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        
        .header p {
            opacity: 0.9;
        }
        
        .content {
            padding: 30px;
        }
        
        .nav {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        
        .nav a {
            display: inline-block;
            padding: 10px 20px;
            background: #f1f3f5;
            color: #495057;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s;
            font-weight: bold;
        }
        
        .nav a:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #495057;
            font-weight: bold;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .btn-submit {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.3s;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        
        .data-table th {
            background: #667eea;
            color: white;
            padding: 12px;
            text-align: left;
        }
        
        .data-table td {
            padding: 12px;
            border-bottom: 1px solid #e9ecef;
        }
        
        .data-table tr:hover {
            background: #f8f9fa;
        }
        
        .footer {
            text-align: center;
            padding: 20px;
            color: #6c757d;
            border-top: 1px solid #e9ecef;
            font-size: 14px;
        }
        
        @media (max-width: 600px) {
            .container {
                margin: 10px;
            }
            .content {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📝 Form Input Mahasiswa</h1>
            <p>Praktikum 10 - PHP Object Oriented Programming</p>
        </div>
        
        <div class="content">
            <!-- Navigation -->
            <div class="nav">
                <a href="index.php">🏠 Home</a>
                <a href="mobil.php">🚗 Class Mobil</a>
                <a href="form.php">📝 Form Input</a>
                <a href="database.php">💾 Database</a>
            </div>
            
            <!-- Message Alert -->
            <?php if (!empty($message)): ?>
                <?php echo $message; ?>
            <?php endif; ?>
            
            <!-- Form Input -->
            <form method="POST" action="">
                <div class="form-group">
                    <label for="nim">NIM</label>
                    <input type="text" id="nim" name="nim" 
                           placeholder="Contoh: 202101001" 
                           value="<?php echo isset($_POST['nim']) ? htmlspecialchars($_POST['nim']) : ''; ?>"
                           required>
                </div>
                
                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" 
                           placeholder="Contoh: Ahmad Santoso"
                           value="<?php echo isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : ''; ?>"
                           required>
                </div>
                
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" id="alamat" name="alamat" 
                           placeholder="Contoh: Jl. Merdeka No. 12, Jakarta"
                           value="<?php echo isset($_POST['alamat']) ? htmlspecialchars($_POST['alamat']) : ''; ?>"
                           required>
                </div>
                
                <button type="submit" class="btn-submit">💾 Simpan Data</button>
            </form>
            
            <!-- Data Table -->
            <?php if ($conn): ?>
                <?php
                $result = $conn->query("SELECT * FROM users ORDER BY id DESC LIMIT 10");
                if ($result && $result->num_rows > 0):
                ?>
                <h3 style="margin-top: 30px; color: #495057;">📋 Data Terbaru</h3>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        while ($row = $result->fetch_assoc()):
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo htmlspecialchars($row['nim']); ?></td>
                            <td><?php echo htmlspecialchars($row['nama']); ?></td>
                            <td><?php echo htmlspecialchars(substr($row['alamat'], 0, 30)); ?>...</td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <p style="text-align: center; margin-top: 10px; color: #6c757d;">
                    Total data: <?php echo $result->num_rows; ?>
                </p>
                <?php else: ?>
                <div style="text-align: center; padding: 20px; color: #6c757d; background: #f8f9fa; border-radius: 8px; margin-top: 20px;">
                    📭 Belum ada data. Silakan input data pertama Anda!
                </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        
        <div class="footer">
            <p>Praktikum 10 - Universitas Pelita Bangsa © 2024</p>
        </div>
    </div>
    
    <script>
        // Animasi form submit
        document.querySelector('form').addEventListener('submit', function(e) {
            const btn = document.querySelector('.btn-submit');
            btn.innerHTML = '⏳ Menyimpan...';
            btn.disabled = true;
            setTimeout(() => {
                btn.innerHTML = '💾 Simpan Data';
                btn.disabled = false;
            }, 2000);
        });
        
        // Auto-focus first input
        document.getElementById('nim').focus();
    </script>
</body>
</html>

<?php
// Tutup koneksi
if ($conn) {
    $conn->close();
}
?>