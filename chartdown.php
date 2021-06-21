<html>
<head>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<link rel="stylesheet" href="style.css">

</head>
<body>
<figure class="highcharts-figure">
    <div id="linechart"></div>
    <p class="highcharts-description">
    Berikut merupakan grafik untuk menampilkan kategori film terlaris pada persewaan dari sakila berdasarkan nama kota.
    </p>
    <div id="barchart"></div>
    <p class="highcharts-description">
    Berikut merupakan grafik untuk menampilkan kategori film terlaris pada persewaan dari sakila berdasarkan kategori.
    </p>
</figure>

<?php 
include 'data.php';
include 'data2.php';
include 'data3.php';

$data = json_decode($data, TRUE);
$data2 = json_decode($data2, TRUE);
$data3 = json_decode($data3, TRUE);
?>


<script type="text/javascript">
//create barchart
Highcharts.chart('barchart', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Data Film Terlaris Berdasarkan Kategori WHSAKILA'
    },
    subtitle: {
        text: 'Source: Database WHSakila2021'
    },
    xAxis: {
        categories: [
            <?php for ($i=0; $i < count($data3); $i++):?>
                <?= $data3[$i]["bulan"]; ?>,
            <?php endfor;?>
        ]
    },
    yAxis: {
        title: {
            text: 'Disewa ke-'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [
        <?php for ($i=0; $i < count($data3); $i+=5):?>
        {
        name: '<?= $data3[$i]["kategori"]; ?>',
        data: [
            <?php for ($a=$i; $a < $i+5; $a++):?>
                <?= $data3[$a]["persen"]; ?>,
            <?php endfor;?>
            ]
        },
        <?php endfor;?>
    ]
});

// Create the linechart
Highcharts.chart('linechart', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Data Film Terlaris Berdasarkan Kota WHSakila'
    },
    subtitle: {
        text: 'Click the columns to view versions. Source: <a href="http://statcounter.com" target="_blank">statcounter.com</a>'
    },
    accessibility: {
        announceNewData: {
            enabled: true
        }
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: 'Disewakan ke-'
        }

    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{point.y:.1f}%'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
    },

    series: [
        {
            name: "Kategori",
            colorByPoint: true,
            data: [
                <?php foreach ($data as $data):?>
                {
                    name: '<?= $data["name"]; ?>',
                    y: <?= $data["y"]; ?>,
                    drilldown: '<?= $data["name"]; ?>'
                },
                <?php endforeach;?>
            ]
        }
    ],
    drilldown: {
        series: [
            <?php for ($i=0; $i < count($data2); $i+=5):?>
            {
                name: "<?= $data2[$i]["kategori"]; ?>",
                id: "<?= $data2[$i]["kategori"]; ?>",
                data: [
                    <?php for ($a=$i; $a < $i+5; $a++):?>
                    [
                        "<?= $data2[$a]["bulan"]; ?>",
                        <?= floatval($data2[$a]["persen"]); ?>
                    ],
                    <?php endfor;?>
                ]
            },
            <?php endfor;?>
        ]}
});
</script>
</body>
</html>