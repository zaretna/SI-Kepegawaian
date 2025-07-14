fetch('../process/get_home.php?type=gender')
.then(response => response.json())
.then(result => {
    const data = result.data;
    console.log(data);
    const ctx = document.getElementById('barchart').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jenis Kelamin'],
            datasets: [
                {
                    label: 'Laki-laki',
                    data: [data['laki-laki']],
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Perempuan',
                    data: [data['perempuan']],
                    backgroundColor: 'rgba(255, 99, 132, 0.7)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
        responsive: true,
        scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        callback: function(value) {
                            return Math.round(value); // Selalu bulatkan
                        }
                    }
                }
            }
        }
    });
})


