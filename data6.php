<?php
require('koneksi.php');

$sql1 = "SELECT f.kategori kategori, 
        t.bulan as bulan,
       sum(fp.amount) as pendapatan 
    FROM film f, fakta_pendapatan fp, time t 
WHERE (f.film_id = fp.film_id) AND (t.time_id = fp.time_id) 
GROUP BY kategori, bulan";

$sql2 = "SELECT f.kategori kategori, 
                sum(fp.amount) as pembagi 
                FROM film f 
                JOIN fakta_pendapatan fp 
                ON (f.film_id = fp.film_id) 
                GROUP BY kategori";

$result1 = mysqli_query($conn,$sql1);
$result2 = mysqli_query($conn,$sql2);

$pendapatan = array();
$pembagi = array();

while ($row = mysqli_fetch_array($result1)) {
    array_push($pendapatan,array(
        "pendapatan"=>$row['pendapatan'],
        "bulan" => $row['bulan'],
        "kategori" => $row['kategori']
    ));
}

while ($row = mysqli_fetch_array($result2)) {
    array_push($pembagi,array(
        "kategori" => $row['kategori'],
        "pembagi"=>$row['pembagi']
    ));
}

$arrayLength2 = count($pembagi);
$arrayLength = count($pendapatan);

$a = 0;
$i = 0;
$hasil = array();

function countPersen($nilai, $pembagi){

    return $nilai/$pembagi*100;
}

$hasil = array();
foreach ($pembagi as $item) {
    foreach ($pendapatan as $dapat) {
        if ($item["kategori"]==$dapat["kategori"]){
            array_push($hasil,array(
                "kategori" => $dapat['kategori'],
                "persen" => countPersen(floatval($dapat["pendapatan"]), floatval($item["pembagi"])),
                "bulan" => $dapat['bulan']
            ));

        }

        $i++;
    }

}

$data6 = json_encode($hasil);

?>