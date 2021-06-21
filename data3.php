<?php
require('koneksi.php');

$sql1 = "SELECT f.kategori kategori, 
        t.bulan as bulan,
       COUNT(fp.film_id) as pendapatan 
    FROM film f, fakta_pendapatan fp, time t 
WHERE (f.film_id = fp.film_id) AND (t.time_id = fp.time_id) 
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

$data3 = json_encode($pendapatan);

?>