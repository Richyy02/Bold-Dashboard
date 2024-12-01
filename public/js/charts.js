const cssColors = (color) => {
    return getComputedStyle(document.documentElement).getPropertyValue(color)
}

const getColor = () => {
    return window.localStorage.getItem('color') ?? 'red'
}

const colors = {
    primary: cssColors(`--color-${getColor()}`),
    primaryLight: cssColors(`--color-${getColor()}-light`),
    primaryLighter: cssColors(`--color-${getColor()}-lighter`),
    primaryDark: cssColors(`--color-${getColor()}-dark`),
    primaryDarker: cssColors(`--color-${getColor()}-darker`),
}


const lineChartUpTime = new Chart(document.getElementById('lineChartUpTime'), {
    type: 'line',
    data: {
        labels: JSON.parse(document.getElementById("lineChartUpTime").dataset.datetime),
        datasets: [
            {
                data: JSON.parse(document.getElementById("lineChartUpTime").dataset.uptime),
                fill: false,
                borderColor: colors.primary,
                borderWidth: 2,
                pointRadius: 0,
                pointHoverRadius: 0,
                tension: 0,
            },
        ],
    },
    options: {
        responsive: true,
        scales: {
            yAxes: [
                {
                    gridLines: false,
                    ticks: {
                        beginAtZero: false,
                        stepSize: 50,
                        fontSize: 12,
                        fontColor: '#97a4af',
                        fontFamily: 'Open Sans, sans-serif',
                        padding: 50,
                        tension: 0,
                    },
                },
            ],
            xAxes: [
                {
                    gridLines: false,
                    ticks: {
                        maxTicksLimit: 15,
                    }
                },
            ],
        },
        maintainAspectRatio: false,
        legend: {
            display: false,
        },
        tooltips: {
            hasIndicator: true,
            intersect: false,
            callbacks: {
                label: function (tooltipItem, data) {
                    const value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                    return +value + '%';
                }
            }
        },
    },
})

const minValue = Math.min(...JSON.parse(document.getElementById("lineChart").dataset.totaltime));
const maxValue = Math.max(...JSON.parse(document.getElementById("lineChart").dataset.totaltime));
const range = maxValue - minValue;
const desiredTickCount = 4;
let roughStepSize = range / desiredTickCount;
const magnitude = Math.floor(Math.log10(roughStepSize));
const roundingFactor = 10 ** magnitude;
let stepSize = Math.ceil(roughStepSize / roundingFactor) * roundingFactor;
if (range / stepSize > desiredTickCount) {
    stepSize *= 2;
}

const lineChartTotalTime = new Chart(document.getElementById('lineChart'), {
    type: 'line',
    data: {
        labels: JSON.parse(document.getElementById("lineChart").dataset.dateadd),
        datasets: [
            {
                data: JSON.parse(document.getElementById("lineChart").dataset.totaltime),
                fill: false,
                borderColor: colors.primary,
                borderWidth: 2,
                pointRadius: 0,
                pointHoverRadius: 0,
            },
        ],
    },
    options: {
        responsive: true,
        scales: {
            yAxes: [
                {
                    gridLines: false,
                    ticks: {
                        beginAtZero: false,
                        stepSize: stepSize,
                        fontSize: 12,
                        fontColor: '#97a4af',
                        fontFamily: 'Open Sans, sans-serif',
                        padding: 20,
                    },
                },
            ],
            xAxes: [
                {
                    gridLines: false,

                },
            ],
        },
        maintainAspectRatio: false,
        legend: {
            display: false,
        },
        tooltips: {
            hasIndicator: true,
            intersect: false,
            callbacks: {
                label: function (tooltipItem, data) {
                    const value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                    return +value + ' ms';
                }
            }
        },
    },
})
const jsonResponse =  JSON.parse(document.getElementById("barChartSentCount").dataset.date);
const labels = JSON.parse(document.getElementById("barChartSentCount").dataset.date);
const data = {
    labels: labels,
    datasets: [
        {
            label: 'Sent',
            data: JSON.parse(document.getElementById("barChartSentCount").dataset.sent),
            backgroundColor: colors.primary
        },
        {
            label: 'SMTPApiError',
            data: JSON.parse(document.getElementById("barChartSentCount").dataset.smtpapierror),
            backgroundColor: '#001444'
        },
        {
            label: 'HardBounce',
            data: JSON.parse(document.getElementById("barChartSentCount").dataset.hardbounce),
            backgroundColor: '#0031a1'
        }
    ]
}
const barChart = new Chart(document.getElementById('barChartSentCount'), {
    type: 'bar',
    data: data,
    options: {
        scales: {
            yAxes: [
                {
                    gridLines: false,

                    ticks: {
                        beginAtZero: true,
                        stepSize: 200,
                        fontSize: 12,
                        fontColor: '#97a4af',
                        fontFamily: 'Open Sans, sans-serif',
                        padding: 10,
                    },
                },
            ],
            xAxes: [
                {
                    gridLines: false,

                    ticks: {
                        fontSize: 12,
                        fontColor: '#97a4af',
                        fontFamily: 'Open Sans, sans-serif',
                        padding: 5,
                    },
                    categoryPercentage: 0.5,
                    maxBarThickness: '10',
                    stacked: true
                },
            ],
        },
        cornerRadius: 2,
        maintainAspectRatio: false,
        legend: {
            display: false,
        },
        tooltips:{
            mode: 'label',
            callbacks: {
                label: function(tooltipItem, data) {
                    const date = data.datasets[tooltipItem.datasetIndex].label;
                    const value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                    let total = 0;
                    for (let i = 0; i < data.datasets.length; i++)
                        total += data.datasets[i].data[tooltipItem.index];
                    if (tooltipItem.datasetIndex != data.datasets.length - 1) {
                        return date + ": " + value;
                    } else {
                        return [date + ": " + value];
                    }
                }
            }
        }
    },
})



