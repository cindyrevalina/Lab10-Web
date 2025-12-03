<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
    <style>
        body { 
            font-family: Arial; 
            padding: 20px; 
            background: #f5f5f5;
        }
        h2 { 
            text-align: center; 
            color: #333;
            margin-bottom: 30px;
        }
        table {
            width: 95%;
            margin: 0 auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px 15px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .harga {
            text-align: right;
            font-family: monospace;
        }
    </style>
</head>
<body>
    <h2>📦 DATA BARANG</h2>
    
    <?php
    $koneksi = mysqli_connect("localhost", "root", "", "latihan1");
    if (!$koneksi) die("❌ Gagal konek database");
    
    $query = mysqli_query($koneksi, "SELECT * FROM data_barang");
    
    if (mysqli_num_rows($query) > 0) {
        echo "<table>";
        echo "<tr>
                <th width='5%'>ID</th>
                <th width='25%'>Nama Barang</th>
                <th width='15%'>Kategori</th>
                <th width='15%'>Harga Beli</th>
                <th width='15%'>Harga Jual</th>
                <th width='10%'>Stok</th>
              </tr>";
        
        while ($row = mysqli_fetch_assoc($query)) {
            echo "<tr>";
            echo "<td>" . $row['id_barang'] . "</td>";
            echo "<td><b>" . $row['nama'] . "</b></td>";
            echo "<td>" . $row['kategori'] . "</td>";
            echo "<td class='harga'>Rp " . number_format($row['harga_beli'], 0, ',', '.') . "</td>";
            echo "<td class='harga'>Rp " . number_format($row['harga_jual'], 0, ',', '.') . "</td>";
            echo "<td align='center'><b>" . $row['stok'] . "</b></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p align='center'>Tidak ada data barang</p>";
    }
    
    mysqli_close($koneksi);
    ?>
</body>
</html>