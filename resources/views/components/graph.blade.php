<div>
    <canvas id="myChart"></canvas>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = <?php echo $data ?>;
    const data = {
        labels: labels,
        datasets: [{
            label: 'Цена',
            backgroundColor: 'rgb(99,250,255)',
            borderColor: 'rgb(99,174,255)',
            data: <?php echo $price; ?>,
        }]
    };

    const config = {
        type: 'bar',
        data: data,
        options: {}
    };

    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );
</script>
