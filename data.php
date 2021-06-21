<?php
require('koneksi.php');

$sql = "SELECT s.nama_kota nama_toko, 
        SUM(p.amount) AS total
        FROM store s, fakta_pendapatan p 
        WHERE s.store_id = p.store_id GROUP BY s.nama_kota";
$result = mysqli_query($conn,$sql);

$hasil = array();

while ($row = mysqli_fetch_array($result)) {
    array_push($hasil,array(
        "name"=>$row['nama_toko'],
        "total"=>$row['total']
    ));
}

$data = json_encode($hasil);

?>