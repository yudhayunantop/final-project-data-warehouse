<?php
require('koneksi.php');

$sql = "SELECT f.kategori, 
        SUM(p.amount) AS total,
        (SUM(p.amount) / (SELECT SUM(amount) FROM fakta_pendapatan)) * 100 AS 'persentase'
        FROM film f, fakta_pendapatan p 
        WHERE f.film_id = p.film_id GROUP BY f.kategori";
$result = mysqli_query($conn,$sql);

$hasil = array();

while ($row = mysqli_fetch_array($result)) {
    array_push($hasil,array(
        "name"=>$row['kategori'],
        "total"=>$row['total'],
        "y"=>$row['persentase']
    ));
}

$data5 = json_encode($hasil);

?>