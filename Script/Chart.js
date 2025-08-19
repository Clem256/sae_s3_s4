document.addEventListener('DOMContentLoaded', () => {
    console.log('Page Loaded');
    console.log('labelsD:', labelsD);
    console.log('dataD:', dataD);
    console.log('dates:', dates);
    console.log('times:', times);
    const observer = new MutationObserver(() => {
        const canvas1 = document.getElementById('PourcentagePlateforme');
        const canvas2 = document.getElementById('TimeUpgrade');

        if (canvas1 && canvas2) {
            initCharts(canvas1, canvas2);
        }
    });

    observer.observe(document.body, {childList: true, subtree: true});
});

function initCharts(canvas1, canvas2) {
    function timeToSeconds(time) {
        const [h, m, s] = time.split(':').map(Number);
        return h * 3600 + m * 60 + s;
    }

    const timesInSeconds = times.map(timeToSeconds);

    const commonOptions = {
        responsive: true,
        plugins: {
            legend: {position: 'top'},
        }
    };

    createPieChart(canvas1, commonOptions);
    createLineChart(canvas2, timesInSeconds, commonOptions);
}

function createPieChart(canvas, commonOptions) {
    new Chart(canvas.getContext('2d'), {
        type: 'pie',
        data: {
            labels: labelsD,
            datasets: [{
                data: dataD,
                backgroundColor: ['red', 'blue', 'green', 'yellow', 'purple', 'orange', 'pink', 'brown', 'grey', 'black'],
            }]
        },
        options: {
            ...commonOptions,
            plugins: {
                ...commonOptions.plugins,
                title: {display: true, text: 'Pourcentage des plateformes'},
                datalabels: {
                    formatter: (value, context) => {
                        const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                        return `${((value / total) * 100).toFixed(1)}%`;
                    },
                    color: '#fff'
                }
            }
        },
        plugins: [ChartDataLabels]
    });
}

function createLineChart(canvas, timesInSeconds, commonOptions) {
    new Chart(canvas.getContext('2d'), {
        type: 'line',
        data: {
            labels: dates,
            datasets: [{
                label: 'Temps (HH:MM:SS)',
                data: timesInSeconds,
                borderColor: 'blue',
                fill: false
            }]
        },
        options: {
            ...commonOptions,
            scales: {
                y: {
                    ticks: {
                        callback: (value) => {
                            const h = Math.floor(value / 3600);
                            const m = Math.floor((value % 3600) / 60);
                            const s = value % 60;
                            return `${h}:${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
                        }
                    }
                }
            },
            plugins: {
                ...commonOptions.plugins,
                title: {display: true, text: 'Temps par date'},
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            const valueInSeconds = context.raw; // Valeur brute (en secondes)
                            const h = Math.floor(valueInSeconds / 3600);
                            const m = Math.floor((valueInSeconds % 3600) / 60);
                            const s = valueInSeconds % 60;
                            return `${h}:${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
                        }
                    }
                }
            }
        }
    });
}
