@extends('layouts.backend')

@section('content')
    <div class="cui__breadcrumbs">
        <div class="cui__breadcrumbs__path">
            <a href="javascript: void(0);">Home</a>
            <span>
      <span class="cui__breadcrumbs__arrow"></span>
      <span>App</span>
    </span>
            <span>
      <span class="cui__breadcrumbs__arrow"></span>
      <strong class="cui__breadcrumbs__current">Welcome to Clean UI Pro</strong>
    </span>
        </div>
    </div>

    <div class="cui__utils__content">
        <div class="row">
            <div class="col-lg-12">
                <div class="cui__utils__heading">
                    <strong class="text-uppercase font-size-16">Today Statistics</strong>
                </div>
                <div class="row">
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body position-relative overflow-hidden">
                                <div class="font-size-36 font-weight-bold text-dark mb-n2">1240</div>
                                <div class="text-uppercase">Transactions</div>
                                <div class="kit__c11__chartContainer">
                                    <div class="kit__c11__chart"></div>
                                </div>
                            </div>
                            <script>
                                /////////////////////////////////////////////////////////////////////////////////////////
                                // "Chart Widget 11" module scripts

                                ;(function($) {
                                    'use strict'
                                    $(function() {
                                        new Chartist.Line(
                                            '.kit__c11__chart',
                                            {
                                                series: [
                                                    {
                                                        className: 'ct-series-a',
                                                        data: [2, 11, 8, 14, 18, 20, 26],
                                                    },
                                                ],
                                            },
                                            {
                                                width: '120px',
                                                height: '107px',

                                                showPoint: false,
                                                showLine: true,
                                                showArea: true,
                                                fullWidth: true,
                                                showLabel: false,
                                                axisX: {
                                                    showGrid: false,
                                                    showLabel: false,
                                                    offset: 0,
                                                },
                                                axisY: {
                                                    showGrid: false,
                                                    showLabel: false,
                                                    offset: 0,
                                                },
                                                chartPadding: 0,
                                                low: 0,
                                            },
                                        )
                                    })
                                })(jQuery)
                            </script>

                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body position-relative overflow-hidden">
                                <div class="font-size-36 font-weight-bold text-dark mb-n2">$256.12</div>
                                <div class="text-uppercase">Income</div>
                                <div class="kit__c11-1__chartContainer">
                                    <div class="kit__c11-1__chart"></div>
                                </div>
                            </div>
                            <script>
                                /////////////////////////////////////////////////////////////////////////////////////////
                                // "Chart Widget 11-1" module scripts

                                ;(function($) {
                                    'use strict'
                                    $(function() {
                                        new Chartist.Line(
                                            '.kit__c11-1__chart',
                                            {
                                                series: [
                                                    {
                                                        className: 'ct-series-a',
                                                        data: [20, 80, 67, 120, 132, 66, 97],
                                                    },
                                                ],
                                            },
                                            {
                                                width: '120px',
                                                height: '107px',

                                                showPoint: false,
                                                showLine: true,
                                                showArea: true,
                                                fullWidth: true,
                                                showLabel: false,
                                                axisX: {
                                                    showGrid: false,
                                                    showLabel: false,
                                                    offset: 0,
                                                },
                                                axisY: {
                                                    showGrid: false,
                                                    showLabel: false,
                                                    offset: 0,
                                                },
                                                chartPadding: 0,
                                                low: 0,
                                            },
                                        )
                                    })
                                })(jQuery)
                            </script>

                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body position-relative overflow-hidden">
                                <div class="font-size-36 font-weight-bold text-dark mb-n2">$56.12</div>
                                <div class="text-uppercase">Outcome</div>
                                <div class="kit__c11-2__chartContainer">
                                    <div class="kit__c11-2__chart"></div>
                                </div>
                            </div>
                            <script>
                                /////////////////////////////////////////////////////////////////////////////////////////
                                // "Chart Widget 11-2" module scripts

                                ;(function($) {
                                    'use strict'
                                    $(function() {
                                        new Chartist.Line(
                                            '.kit__c11-2__chart',
                                            {
                                                series: [
                                                    {
                                                        className: 'ct-series-a',
                                                        data: [42, 40, 80, 67, 84, 20, 97],
                                                    },
                                                ],
                                            },
                                            {
                                                width: '120px',
                                                height: '107px',

                                                showPoint: false,
                                                showLine: true,
                                                showArea: true,
                                                fullWidth: true,
                                                showLabel: false,
                                                axisX: {
                                                    showGrid: false,
                                                    showLabel: false,
                                                    offset: 0,
                                                },
                                                axisY: {
                                                    showGrid: false,
                                                    showLabel: false,
                                                    offset: 0,
                                                },
                                                chartPadding: 0,
                                                low: 0,
                                            },
                                        )
                                    })
                                })(jQuery)
                            </script>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="cui__utils__heading">
                    <strong>LAST MONTH STATISTICS</strong>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="font-weight-bold text-dark font-size-24">
                                    78,367
                                </div>
                                <div>Total Sales</div>
                                <div class="kit__c4__chart height-200"></div>

                                <script>
                                    /////////////////////////////////////////////////////////////////////////////////////////
                                    // "Chart Widget 4" module scripts

                                    ;(function($) {
                                        'use strict'
                                        $(function() {
                                            /////////////////////////////////////////////////////////////////////////////////////////
                                            new Chartist.Line(
                                                '.kit__c4__chart',
                                                {
                                                    series: [
                                                        {
                                                            className: 'ct-series-a',
                                                            data: [2, 4, 5, 4, 5, 6, 7, 5],
                                                        },
                                                    ],
                                                },
                                                {
                                                    chartPadding: {
                                                        right: 0,
                                                        left: 0,
                                                        top: 5,
                                                        bottom: 5,
                                                    },
                                                    fullWidth: true,
                                                    showPoint: false,
                                                    lineSmooth: true,
                                                    axisY: {
                                                        showGrid: false,
                                                        showLabel: false,
                                                        offset: 0,
                                                    },
                                                    axisX: {
                                                        showGrid: false,
                                                        showLabel: false,
                                                        offset: 0,
                                                    },
                                                    showArea: false,
                                                },
                                            )
                                            /////////////////////////////////////////////////////////////////////////////////////////
                                        })
                                    })(jQuery)
                                </script>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="font-weight-bold text-dark font-size-24">
                                    +90%
                                </div>
                                <div>Sales Rise</div>
                                <div class="kit__c4-1__chart height-200"></div>

                                <script>
                                    /////////////////////////////////////////////////////////////////////////////////////////
                                    // "Chart Widget 4-1" module scripts

                                    ;(function($) {
                                        'use strict'
                                        $(function() {
                                            /////////////////////////////////////////////////////////////////////////////////////////
                                            new Chartist.Line(
                                                '.kit__c4-1__chart',
                                                {
                                                    series: [
                                                        {
                                                            className: 'ct-series-b',
                                                            data: [1, 5, 2, 5, 4, 7],
                                                        },
                                                    ],
                                                },
                                                {
                                                    chartPadding: {
                                                        right: 0,
                                                        left: 0,
                                                        top: 5,
                                                        bottom: 5,
                                                    },
                                                    fullWidth: true,
                                                    showPoint: false,
                                                    lineSmooth: true,
                                                    axisY: {
                                                        showGrid: false,
                                                        showLabel: false,
                                                        offset: 0,
                                                    },
                                                    axisX: {
                                                        showGrid: false,
                                                        showLabel: false,
                                                        offset: 0,
                                                    },
                                                    showArea: false,
                                                },
                                            )
                                            /////////////////////////////////////////////////////////////////////////////////////////
                                        })
                                    })(jQuery)
                                </script>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="font-weight-bold text-dark font-size-24">
                                    900
                                </div>
                                <div>Completed</div>
                                <div class="kit__c4-2__chart height-200"></div>

                                <script>
                                    /////////////////////////////////////////////////////////////////////////////////////////
                                    // "Chart Widget 4-2" module scripts

                                    ;(function($) {
                                        'use strict'
                                        $(function() {
                                            /////////////////////////////////////////////////////////////////////////////////////////
                                            new Chartist.Line(
                                                '.kit__c4-2__chart',
                                                {
                                                    series: [
                                                        {
                                                            className: 'ct-series-j',
                                                            data: [2, 3, 2, 4, 6, 5],
                                                        },
                                                    ],
                                                },
                                                {
                                                    chartPadding: {
                                                        right: 0,
                                                        left: 0,
                                                        top: 5,
                                                        bottom: 5,
                                                    },
                                                    fullWidth: true,
                                                    showPoint: false,
                                                    lineSmooth: true,
                                                    axisY: {
                                                        showGrid: false,
                                                        showLabel: false,
                                                        offset: 0,
                                                    },
                                                    axisX: {
                                                        showGrid: false,
                                                        showLabel: false,
                                                        offset: 0,
                                                    },
                                                    showArea: false,
                                                },
                                            )
                                            /////////////////////////////////////////////////////////////////////////////////////////
                                        })
                                    })(jQuery)
                                </script>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="font-weight-bold text-dark font-size-24">
                                    $78.62M
                                </div>
                                <div>Paid in Crypto</div>
                                <div class="kit__c4-3__chart height-200"></div>

                                <script>
                                    /////////////////////////////////////////////////////////////////////////////////////////
                                    // "Chart Widget 4-3" module scripts

                                    ;(function($) {
                                        'use strict'
                                        $(function() {
                                            /////////////////////////////////////////////////////////////////////////////////////////
                                            new Chartist.Line(
                                                '.kit__c4-3__chart',
                                                {
                                                    series: [
                                                        {
                                                            className: 'ct-series-d',
                                                            data: [1, 5, 2, 5, 4, 7],
                                                        },
                                                    ],
                                                },
                                                {
                                                    chartPadding: {
                                                        right: 0,
                                                        left: 0,
                                                        top: 5,
                                                        bottom: 5,
                                                    },
                                                    fullWidth: true,
                                                    showPoint: false,
                                                    lineSmooth: true,
                                                    axisY: {
                                                        showGrid: false,
                                                        showLabel: false,
                                                        offset: 0,
                                                    },
                                                    axisX: {
                                                        showGrid: false,
                                                        showLabel: false,
                                                        offset: 0,
                                                    },
                                                    showArea: false,
                                                },
                                            )

                                            /////////////////////////////////////////////////////////////////////////////////////////
                                        })
                                    })(jQuery)
                                </script>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="cui__utils__heading mb-0">
                            <strong>Recently Referrals</strong>
                        </div>
                        <div class="text-muted">
                            Block with important Recently Referrals information
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-default">
                                <tr>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Age</th>
                                    <th>Office</th>
                                    <th>Date</th>
                                    <th>Salary</th>
                                </tr>
                                </thead>
                                <tr>
                                    <td>Damon</td>
                                    <td>5516 Adolfo Green</td>
                                    <td>18</td>
                                    <td>Littelhaven</td>
                                    <td>2014/06/13</td>
                                    <td>553.536</td>
                                </tr>
                                <tr>
                                    <td>Miracle</td>
                                    <td>176 Hirthe Squares</td>
                                    <td>35</td>
                                    <td>Ryleetown</td>
                                    <td>2013/09/27</td>
                                    <td>784.802</td>
                                </tr>
                                <tr>
                                    <td>Torrey</td>
                                    <td>1995 Richie Neck</td>
                                    <td>15</td>
                                    <td>West Sedrickstad</td>
                                    <td>2014/09/12</td>
                                    <td>344.302</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="cui__utils__heading">
                    <strong>Your cards (3)</strong>
                    <button class="ml-3 btn btn-outline-default btn-sm">View All</button>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="position-relative py-3 px-4 text-center">
                                <div class="kit__g17__flag">$560,245.35</div>
                                <div class="font-size-70 pt-3 pb-w text-gray-4">
                                    <i class="fe fe-star"></i>
                                </div>
                                <h5 class="font-size-24 font-weight-bold mb-1">David Beckham</h5>
                                <div class="font-size-18 text-uppercase mb-3">8748-XXXX-1678-5416</div>
                                <div class="font-weight-bold font-size-18 text-uppercase mb-4">MASTERCARD</div>
                                <div class="border-top pt-3 font-italic">Expires at 03/22</div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="position-relative py-3 px-4 text-center">
                                <div class="kit__g17__flag">$2,156.20</div>
                                <div class="font-size-70 pt-3 pb-w text-gray-4">
                                    <i class="fe fe-star"></i>
                                </div>
                                <h5 class="font-size-24 font-weight-bold mb-1">Matt Daemon</h5>
                                <div class="font-size-18 text-uppercase mb-3">8748-XXXX-1678-5416</div>
                                <div class="font-weight-bold font-size-18 text-uppercase mb-4">Visa</div>
                                <div class="border-top pt-3 font-italic">Expires at 03/22</div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="position-relative py-3 px-4 text-center">
                                <div class="kit__g17__flag">$10,2000.00</div>
                                <div class="font-size-70 pt-3 pb-w text-gray-4">
                                    <i class="fe fe-star"></i>
                                </div>
                                <h5 class="font-size-24 font-weight-bold mb-1">Angelina Jolie</h5>
                                <div class="font-size-18 text-uppercase mb-3">8748-XXXX-1678-5416</div>
                                <div class="font-weight-bold font-size-18 text-uppercase mb-4">Visa</div>
                                <div class="border-top pt-3 font-italic">Expires at 03/22</div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="cui__utils__heading">
                    <strong>Your accounts (6)</strong>
                    <button class="ml-3 btn btn-outline-default btn-sm">View All</button>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="py-3 px-4">
                                <div class="d-flex flex-wrap-reverse align-items-center pb-3">
                                    <div class="mr-auto">
                                        <div class="text-uppercase font-weight-bold font-size-24 text-dark">
                                            US 4658-1657-1235
                                        </div>
                                        <div class="font-size-18">
                                            $2,156.78
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 font-size-36 text-gray-4 pl-1">
                                        <i class="fe fe-server"></i>
                                    </div>
                                </div>
                                <div class="font-italic font-size-14 text-center border-top pt-3">
                                    Current month charged: 10,200.00
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="py-3 px-4">
                                <div class="d-flex flex-wrap-reverse align-items-center pb-3">
                                    <div class="mr-auto">
                                        <div class="text-uppercase font-weight-bold font-size-24 text-dark">
                                            IBAN 4658-1235-1567-8000
                                        </div>
                                        <div class="font-size-18">
                                            $12,136.78
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 font-size-36 text-gray-4 pl-1">
                                        <i class="fe fe-server"></i>
                                    </div>
                                </div>
                                <div class="font-italic font-size-14 text-center border-top pt-3">
                                    Current month charged: 12,136.78
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="py-3 px-4">
                                <div class="d-flex flex-wrap-reverse align-items-center pb-3">
                                    <div class="mr-auto">
                                        <div class="text-uppercase font-weight-bold font-size-24 text-dark">
                                            IBAN 4658-1235-1567-8000
                                        </div>
                                        <div class="font-size-18">
                                            $12,136.78
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 font-size-36 text-gray-4 pl-1">
                                        <i class="fe fe-server"></i>
                                    </div>
                                </div>
                                <div class="font-italic font-size-14 text-center border-top pt-3">
                                    Current month charged: 12,136.78
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="py-3 px-4">
                                <div class="d-flex flex-wrap-reverse align-items-center pb-3">
                                    <div class="mr-auto">
                                        <div class="text-uppercase font-weight-bold font-size-24 text-dark">
                                            US 4658-1657-1235
                                        </div>
                                        <div class="font-size-18">
                                            $2,156.78
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 font-size-36 text-gray-4 pl-1">
                                        <i class="fe fe-server"></i>
                                    </div>
                                </div>
                                <div class="font-italic font-size-14 text-center border-top pt-3">
                                    Current month charged: 10,200.00
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="cui__utils__heading">
                    <strong>Recent transactions (167)</strong>
                    <button class="ml-3 btn btn-outline-default btn-sm">View All</button>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="kit__g6 pt-3">
                                <div class="kit__g6__status bg-danger"></div>
                                <div class="d-flex flex-nowrap align-items-center pb-3 pl-4 pr-4">
                                    <div class="mr-auto">
                                        <div class="text-uppercase font-weight-bold font-size-24 text-dark">-$1,125</div>
                                        <div class="font-size-18">4512-XXXX-1678-7528</div>
                                    </div>
                                    <div class="ml-1 text-danger">
                                        <i class="fe fe-arrow-right-circle font-size-40"></i>
                                    </div>
                                </div>
                                <div class="kit__g6__footer py-3 pl-4">
                                    To DigitalOcean Cloud Hosting, Winnetka, LA
                                </div>
                            </div>

                        </div>
                        <div class="card">
                            <div class="kit__g6 pt-3">
                                <div class="kit__g6__status bg-success"></div>
                                <div class="d-flex flex-nowrap align-items-center pb-3 pl-4 pr-4">
                                    <div class="mr-auto">
                                        <div class="text-uppercase font-weight-bold font-size-24 text-dark">+$10,264</div>
                                        <div class="font-size-18">4512-XXXX-1678-7528</div>
                                    </div>
                                    <div class="ml-1 text-success">
                                        <i class="fe fe-arrow-left-circle font-size-40"></i>
                                    </div>
                                </div>
                                <div class="kit__g6__footer py-3 pl-4">
                                    From Tesla Cars, Inc
                                </div>
                            </div>

                        </div>
                        <div class="card">
                            <div class="kit__g6 pt-3">
                                <div class="kit__g6__status bg-danger"></div>
                                <div class="d-flex flex-nowrap align-items-center pb-3 pl-4 pr-4">
                                    <div class="mr-auto">
                                        <div class="text-uppercase font-weight-bold font-size-24 text-dark">-$1,125</div>
                                        <div class="font-size-18">4512-XXXX-1678-7528</div>
                                    </div>
                                    <div class="ml-1 text-danger">
                                        <i class="fe fe-arrow-right-circle font-size-40"></i>
                                    </div>
                                </div>
                                <div class="kit__g6__footer py-3 pl-4">
                                    To DigitalOcean Cloud Hosting, Winnetka, LA
                                </div>
                            </div>

                        </div>
                        <div class="card">
                            <div class="kit__g6 pt-3">
                                <div class="kit__g6__status bg-success"></div>
                                <div class="d-flex flex-nowrap align-items-center pb-3 pl-4 pr-4">
                                    <div class="mr-auto">
                                        <div class="text-uppercase font-weight-bold font-size-24 text-dark">+$10,264</div>
                                        <div class="font-size-18">4512-XXXX-1678-7528</div>
                                    </div>
                                    <div class="ml-1 text-success">
                                        <i class="fe fe-arrow-left-circle font-size-40"></i>
                                    </div>
                                </div>
                                <div class="kit__g6__footer py-3 pl-4">
                                    From Tesla Cars, Inc
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="text-center pb-5">
                    <button class="btn disabled btn-primary width-200">Load More...</button>
                </div>
            </div>
        </div>

    </div>
@endsection