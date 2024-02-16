const reports = {
    reportEnum: {
        'sales': 'Sale',
        'orders': 'Orders',
        'products': 'Products',
        'brands': 'Brands'
    },
    chartjs: null,
    displayTimeType: function (selectElement) {
        const reportType = $(selectElement).val();
        $('button#buttonSubmit').data('report', reportType);

        if (reportType !== '') {
            $('div#reportTimeType').removeClass('d-none');
        } else {
            $('div#reportTimeType').addClass('d-none');
            $('select#reportTimeType').val('');
            $('div#timeLineReport').addClass('d-none');
        }
    },
    displayTimeLineReport: function (selectElement) {
        const reportTimeType = $(selectElement).val();
        $('div#timeLineReport').find('div.form-group').addClass('d-none');

        if (reportTimeType !== '') {
            $('div#timeLineReport').removeClass('d-none');
            const buttonSubmit = $('button#buttonSubmit');

            switch (reportTimeType) {
                case 'date':
                    $('div#dateReport').removeClass('d-none');
                    buttonSubmit.data('type', 'date')
                    break;
                case 'week':
                    $('div#weekReport').removeClass('d-none');
                    buttonSubmit.data('type', 'week')
                    break;
                case 'month':
                    $('div#monthReport').removeClass('d-none');
                    buttonSubmit.data('type', 'month')
                    break;

                default:
                    $('div#yearReport').removeClass('d-none');
                    buttonSubmit.data('type', 'year');
                    break;
            }
        } else {
            $('div#timeLineReport').addClass('d-none');
        }
    },
    displayChart: function (button) {
        $('div#timeLineReport').find('span.text-danger').text('');
        const submitButton = $(button).data('type');

        const reportType = $('select#reportType').val();
        const reportTimeType = $('select#reportTimeType').val();
        let timeLineReport = null

        if (submitButton === 'year') {
            timeLineReport = $('select#year').val();
        } else if (submitButton === 'date') {
            timeLineReport = {
                toDate: $('#toDate').val(),
                fromDate: $('#fromDate').val()
            }
        } else {
            timeLineReport = $(`input#${submitButton}`).val();
        }

        $.ajax({
            url: route('admin.reports.reports'),
            type: 'POST',
            data: {
                reportType: reportType,
                reportTimeType: reportTimeType,
                timeLineReport: timeLineReport
            },
            statusCode: {
                422: function (error) {
                    error = error.responseJSON.errors;
                    if (submitButton === 'date') {
                        $.each(error, function (key, value) {
                            const elementIds = key.split('.');
                            $(`div#${elementIds[0]}`).find(`span#${elementIds[1]}`).text(value);
                        })
                    } else {
                        $(`span#timeLineReport`).text(error.timeLineReport)
                    }
                }
            }
        }).done(function (response) {
            const titleEnum = $('button#buttonSubmit').data('report');
            const text = reports.getReportEnum(titleEnum);
            reports.renderChart(response.labels, response.data, '#line-chart', text, response.title, response.chartType);
        }).fail(function (error) {
            if (error.status !== 422) {
                common.sweetAlertNoButton('Something went wrong!', error.responseJSON.message, 'error')
            }
        })
    },
    renderChart: function (labels, data, targetChart, label = '', text = '', chartType = 'bar') {
        const lineChart = $(targetChart)[0];
        if (reports.chartjs) {
            reports.chartjs.destroy();
        }
        reports.chartjs = new Chart(lineChart, {
            type: chartType,
            data: {
                labels: labels,
                datasets: [
                    {
                        label: label,
                        data: data,
                        backgroundColor: 'rgba(0, 128, 128, 0.3)',
                        borderColor: 'rgba(0, 128, 128, 0.7)',
                        borderWidth: 1
                    },
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: reports.getReportEnum($('button#buttonSubmit').data('report'))
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                indexAxis: chartType === 'bar' ? 'y' : 'x'
            }
        });
    },
    getReportEnum: function (key) {
        return reports.reportEnum[key] ?? key;
    }
}