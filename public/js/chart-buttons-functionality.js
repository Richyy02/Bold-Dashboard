const apiCalls = {
    ohDearTotalTimeWeek: {
        isPending: false,
        lastKnownLabels: [],
        lastKnownTime: [],
    },
    ohDearTotalTimeHour: {
        isPending: false,
        lastKnownLabels: [],
        lastKnownTime: [],
    },
    ohDearUpTimeWeek: {
        isPending: false,
        lastKnownLabels: [],
        lastKnownTime: [],
    },
    ohDearUpTimeMonth: {
        isPending: false,
        lastKnownLabels: [],
        lastKnownTime: [],
    },
    postmarkSentCountWeek: {
        isPending: false,
        lastKnownLabels: [],
        lastKnownTime: [],
    },
    postmarkSentCountMonth: {
        isPending: false,
        lastKnownLabels: [],
        lastKnownTime: [],
    },
};
const totalTimeText = document.getElementById("totalTimeMs")
const upTimeText = document.getElementById('upTime')
const postmarkText = document.getElementById('outbound')
const updateCharts = (chartName, labelData, chartData) => {
    labelData.forEach((labelData) => {
        chartName.data.labels.push(labelData);
    });
    chartData.forEach((chartData) => {
        chartName.data.datasets[0].data.push(chartData);
    });
    chartName.update();
};
const fetchData = (url, apiCall, chartName) => {
    apiCall.isPending = true;
    axios.get(url).then(function (response) {
        const {data} = response;
        if (apiCall === apiCalls.ohDearTotalTimeHour) {
            totalTimeText.textContent = "(Last Hour)"
            const oneDayChartLabel = Object.values(data["ohDearData"]["dateAdd"]);
            const oneDayChartTime = Object.values(data["ohDearData"]["totalTimeArray"]);
            apiCall.lastKnownLabels = oneDayChartLabel;
            apiCall.lastKnownTime = oneDayChartTime;
            const lastDataTime = chartName.data.labels.slice(-1)[0];
            const newDate = oneDayChartLabel[oneDayChartLabel.length - 1];
            if (lastDataTime !== newDate) {
                updateCharts(chartName, oneDayChartLabel, oneDayChartTime);
            }
        } else if (apiCall === apiCalls.ohDearTotalTimeWeek) {
            totalTimeText.textContent = "(Last Week)"
            const chartLabel = Object.values(data["getOhDearTotalTimeDataWeek"]["dateAdd"]);
            const chartTime = Object.values(data["getOhDearTotalTimeDataWeek"]["totalTime"]);
            apiCall.lastKnownLabels = chartLabel;
            apiCall.lastKnownTime = chartTime;
            updateCharts(chartName, chartLabel, chartTime);
        } else if (apiCall === apiCalls.ohDearUpTimeWeek) {
            upTimeText.textContent = "(Last Week)"
            const chartLabel = Object.values(data["getOhDearUpTimeData"]["dateTime"]);
            const chartTime = Object.values(data["getOhDearUpTimeData"]["upTime"]);
            apiCall.lastKnownLabels = chartLabel;
            apiCall.lastKnownTime = chartTime;
            const lastDataTime = chartName.data.labels.slice(-1)[0];
            const newDate = chartLabel[chartLabel.length - 1];
            if (lastDataTime !== newDate) {
                updateCharts(chartName, chartLabel, chartTime);
            }
        } else if (apiCall === apiCalls.ohDearUpTimeMonth) {
            upTimeText.textContent = "(Last Year)"
            const chartLabel = Object.values(data["getOhDearUpTimeDataMonth"]["dateTime"]);
            const chartTime = Object.values(data["getOhDearUpTimeDataMonth"]["uptime_percentage"]);
            apiCall.lastKnownLabels = chartLabel;
            apiCall.lastKnownTime = chartTime;
            updateCharts(chartName, chartLabel, chartTime);
        } else if (apiCall === apiCalls.postmarkSentCountWeek) {
            upTimeText.textContent = "(Last Week)"
            const chartLabel = Object.values(data["getPostmarkSentCount"]["date"]);
            const chartTime = Object.values(data["getPostmarkSentCount"]["sent"]);
            apiCall.lastKnownLabels = chartLabel;
            apiCall.lastKnownTime = chartTime;
            updateCharts(chartName, chartLabel, chartTime);
        } else if (apiCall === apiCalls.postmarkSentCountMonth) {
            upTimeText.textContent = "(Last Month)"
            console.log(Object.values(data["getPostMarkSentCountMonth"]))
            const chartLabel = Object.values(data["getPostMarkSentCountMonth"]["date"]);
            const chartTime = Object.values(data["getPostMarkSentCountMonth"]["sent"]);
            apiCall.lastKnownLabels = chartLabel;
            apiCall.lastKnownTime = chartTime;
            updateCharts(chartName, chartLabel, chartTime);
        }

    });
    setTimeout(() => {
        apiCall.isPending = false;
    }, 60000);
};
const ohDearTotalTimeLastHour = () => {
    totalTimeText.textContent = "(Last Hour)"
    lineChartTotalTime.data.labels = [];
    lineChartTotalTime.data.datasets[0].data = [];
    const apiCall = apiCalls.ohDearTotalTimeHour;
    const chartName = lineChartTotalTime;
    if (apiCall.isPending) {
        updateCharts(
            chartName,
            apiCall.lastKnownLabels,
            apiCall.lastKnownTime
        );
    } else {
        const url = '/api/updateOhDearTotalTimeHour/' + document.getElementById('lineChart').dataset.slug;
        fetchData(url, apiCall, chartName);
    }
};
const ohDearTotalTimeLastWeek = () => {
    totalTimeText.textContent = "(Last Week)"
    lineChartTotalTime.data.labels = [];
    lineChartTotalTime.data.datasets[0].data = [];
    const apiCall = apiCalls.ohDearTotalTimeWeek;
    const chartName = lineChartTotalTime;
    if (apiCall.isPending) {
        updateCharts(
            chartName,
            apiCall.lastKnownLabels,
            apiCall.lastKnownTime
        );
    } else {
        const url = '/api/updateOhDearTotalTimeWeek/' + document.getElementById('lineChart').dataset.slug;
        fetchData(url, apiCall, chartName);
    }
};
const ohDearUptimeLastWeek = () => {
    upTimeText.textContent = "(Last Week)"
    lineChartUpTime.data.labels = [];
    lineChartUpTime.data.datasets[0].data = [];
    const apiCall = apiCalls.ohDearUpTimeWeek;
    const chartName = lineChartUpTime;
    if (apiCall.isPending) {
        updateCharts(
            chartName,
            apiCall.lastKnownLabels,
            apiCall.lastKnownTime
        );
    } else {
        const url = '/api/updateOhDearUpTimeWeek/' + document.getElementById('lineChartUpTime').dataset.slug;
        fetchData(url, apiCall, chartName);
    }
};
const ohDearUptimeLastMonth = () => {
    upTimeText.textContent = "(Last Year)"
    lineChartUpTime.data.labels = [];
    lineChartUpTime.data.datasets[0].data = [];
    const apiCall = apiCalls.ohDearUpTimeMonth;
    const chartName = lineChartUpTime;
    if (apiCall.isPending) {
        updateCharts(
            chartName,
            apiCall.lastKnownLabels,
            apiCall.lastKnownTime
        );
    } else {
        const url = '/api/updateOhDearUpTimeMonth/' + document.getElementById('lineChartUpTime').dataset.slug;
        fetchData(url, apiCall, chartName);
    }
};

const postmarkSentCountWeek = () => {
    postmarkText.textContent = "(Last Week)"
    barChart.data.labels = [];
    barChart.data.datasets[0].data = [];
    const apiCall = apiCalls.postmarkSentCountWeek;
    const chartName = barChart;
    if (apiCall.isPending) {
        updateCharts(
            chartName,
            apiCall.lastKnownLabels,
            apiCall.lastKnownTime
        );
    } else {
        const url = '/api/updatePostmarkSentCountWeek/' + document.getElementById('barChartSentCount').dataset.slug;
        fetchData(url, apiCall, chartName)
    }
}
const postmarkSentCountMonth = () => {
    postmarkText.textContent = "(Last Month)"
    barChart.data.labels = [];
    barChart.data.datasets[0].data = [];
    const apiCall = apiCalls.postmarkSentCountMonth;
    const chartName = barChart;
    if (apiCall.isPending) {
        updateCharts(
            chartName,
            apiCall.lastKnownLabels,
            apiCall.lastKnownTime
        );
    } else {
        const url = '/api/updatePostmarkSentCountMonth/' + document.getElementById('barChartSentCount').dataset.slug;
        fetchData(url, apiCall, chartName)
    }
}
