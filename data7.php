<?php
require('koneksi.php');

$sql1 = "SELECT f.kategori kategori, 
t.bulan as bulan,
SUM(fp.lamapinjam) as lamapinjam 
FROM film f, fakta_pendapatan fp, time t 
WHERE (f.film_id = fp.film_id) AND (t.time_id = fp.time_id) 
GROUP BY kategori, bulan";

$result1 = mysqli_query($conn,$sql1);

$lamapinjam = array();

while ($row = mysqli_fetch_array($result1)) {
    array_push($lamapinjam,array(
        "lamapinjam"=>$row['lamapinjam'],
        "bulan" => $row['bulan'],
        "kategori" => $row['kategori']
    ));
}
$data7 = json_encode($lamapinjam);

?>