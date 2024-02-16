@extends('admin::layouts.master')

@php
    $constantsClass = Modules\Admin\App\Constructs\Constants::class;
    $reports = $constantsClass::REPORT_TYPES;
@endphp
@section('content')
    <label class="mt-2 d-flex">Report type</label>
    <div class="row form-group">
        <div class="col-4">
            <select id="reportType" name="reportType" class="custom-select" onchange="reports.displayTimeType(this)">
                <option value="">Select report</option>
                @foreach ($reports as $report)
                    <option value="{{ $report['value'] }}">
                        {{ $report['name'] }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-2 d-none" id="reportTimeType">
            <select id="reportTimeType" name="reportTimeType" class="custom-select"
                onchange="reports.displayTimeLineReport(this)">
                <option value="">Select report time line</option>
                <option value="date">Daily</option>
                <option value="week">Weekly</option>
                <option value="month">Monthly</option>
                <option value="year">Yearly</option>
            </select>
        </div>
        <div class="col-4">
            <button type="button" class="btn btn-primary" id="buttonSubmit" data-type="" data-report=""
                onclick="reports.displayChart(this)">Generate</button>
        </div>
    </div>
    <div class="row form-group d-none" id="timeLineReport">
        <div class="col-4 form-group mb-2 d-none" id="dateReport" data-type="date">
            <div class="row">
                <div class="col-md">
                    <input type="date" class="form-control" id="fromDate">
                    <span id="fromDate" class="text-danger d-flex mb-2"
                        style="font-size:80% !important"></span>
                </div>
                <div class="col-md">
                    <input type="date" class="form-control" id="toDate">
                    <span id="toDate" class="text-danger d-flex mb-2"
                        style="font-size:80% !important"></span>
                </div>
            </div>
        </div>
        <div class="col-4 form-group mb-2 d-none" id="monthReport" data-type="month">
            <input type="month" class="form-control" id="month">
        </div>
        <div class="col-4 form-group mb-2 d-none" id="weekReport" data-type="week">
            <input type="week" class="form-control" id="week">
        </div>
        <div class="col-4 form-group d-none" id="yearReport" data-type="year">
            <select id="year" name="year" class="custom-select">
                <option value="" selected>Select year</option>
                @foreach (range(date('Y'), 1910) as $year)
                    <option value="{{ $year }}">
                        {{ $year }}
                    </option>
                @endforeach
            </select>
        </div>
        <span id="timeLineReport" class="text-danger d-flex mb-2" style="font-size:80% !important"></span>
    </div>
    <div>
        <canvas id="line-chart" width="400" height="150"></canvas>
    </div>
@endsection

@section('main-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script src="{{ asset('admin/js/reports.js') }}"></script>
@endsection
