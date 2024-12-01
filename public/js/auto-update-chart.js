const update = () => {
    if (lineChartTotalTime.data.labels.slice(-1)[0].includes('/')) {
        const lastDataTime = lineChartTotalTime.data.labels.slice(-1)[0];
        axios.get('/api/updateOhDearTotalTimeWeek/' + document.getElementById('lineChart').dataset.slug).then(function (response) {
            let newDate = Object.values(response["data"]["getOhDearTotalTimeDataWeek"]["dateAdd"])[Object.values(response["data"]["getOhDearTotalTimeDataWeek"]["dateAdd"]).length - 1]
            if (lastDataTime !== newDate) {
                lineChartTotalTime.data.labels.shift()
                lineChartTotalTime.data.datasets[0].data.shift()
                lineChartTotalTime.data.labels.push(newDate)
                lineChartTotalTime.data.datasets[0].data.push(Object.values(response["data"]["getOhDearTotalTimeDataWeek"]["totalTime"])[Object.values(response["data"]["getOhDearTotalTimeDataWeek"]["totalTime"]).length - 1])
                lineChartTotalTime.update();
            }
        })
    } else {
        axios.get('/api/updateOhDearTotalTimeHour/' + document.getElementById('lineChart').dataset.slug).then(function (response) {
            const lastDataTime = lineChartTotalTime.data.labels.slice(-1)[0];
            let newDate = Object.values(response["data"]["ohDearData"]["dateAdd"])[Object.values(response["data"]["ohDearData"]["dateAdd"]).length - 1]
            if (lastDataTime !== newDate) {
                lineChartTotalTime.data.labels.shift()
                lineChartTotalTime.data.datasets[0].data.shift()
                lineChartTotalTime.data.labels.push(newDate)
                lineChartTotalTime.data.datasets[0].data.push(Object.values(response["data"]["ohDearData"]["totalTimeArray"])[Object.values(response["data"]["ohDearData"]["totalTimeArray"]).length - 1])
                lineChartTotalTime.update();
            }
        })
    }
    axios.get('/api/updatePostmarkSentCount/' + document.getElementById('lineChart').dataset.slug).then(function (response) {
        const lastDataTime = barChart.data.labels.slice(-1)[0];
        let newSentCount = Object.values(response["data"]["getPostmarkSentCount"]["sent"])[Object.values(response["data"]["getPostmarkSentCount"]["sent"]).length -1]
        let newDate = Object.values(response["data"]["getPostmarkSentCount"]['date'])[Object.values(response["data"]["getPostmarkSentCount"]["date"]).length - 1]
        if (lastDataTime !== newDate) {
            barChart.data.labels.shift()
            barChart.data.labels.push(newDate)
        }
        barChart.data.datasets[0].data[barChart.data.datasets[0].data.length -1] = newSentCount
        barChart.update()
    })
}
setInterval(() => {
    update()
}, 60000)

