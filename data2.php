<?php
require('koneksi.php');

$sql1 = "SELECT s.nama_kota kategori, 
        t.bulan as bulan,
       sum(fp.amount) as pendapatan 
    FROM store s, fakta_pendapatan fp, time t 
WHERE (s.store_id = fp.store_id) AND (t.time_id = fp.time_id) 
GROUP BY kategori, bulan";

$result1 = mysqli_query($conn,$sql1);

$pendapatan = array();

while ($row = mysqli_fetch_array($result1)) {
    array_push($pendapatan,array(
        "pendapatan"=>$row['pendapatan'],
        "bulan" => $row['bulan'],
        "kategori" => $row['kategori']
    ));
}

$data2 = json_encode($pendapatan);

?>