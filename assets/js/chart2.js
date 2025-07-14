fetch('../process/get_home.php?type=absensi')
.then(response => response.json())
.then(result => {
    const data = result.data;
    console.log(data);
    const ctx2 = document.getElementById('doughnut');
    
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['Tepat Waktu', 'Terlambat', 'Cuti'],
            datasets: [{
            label: 'Total',
            data: [data['tepat waktu'], data['terlambat'], data['cuti']],
            borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            },
            plugins: {
                legend: {
                    position: 'top'
                }
            }
        }
    });
})
