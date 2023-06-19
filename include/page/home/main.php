<!-- CONTENT -->

<script>
$(window).ready(() => {

})
</script>


<section id="content">

    <!-- MAIN -->
    <main>
        <div class="head-title">
            <div class="left">
                <h1>Home</h1>
                <ul class="breadcrumb">
                    <li>
                        <a href="#">Dashboard</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>
                        <a class="active" href="#">Home</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-12 ">
                <div class="col-md-2 float-end ">
                    <input type="text" name="daterange" id="filter_Date" class="form-control" />
                </div>
            </div>
        </div>
        <ul class="box-info" id="homeDashboard">

        </ul>
        <div class="table-data">
            <div class="order" style="overflow: hidden;">
                <div class="head">
                    <h4>Top 5 Department</h4>


                </div>
                <div id="chartWorkEmp"></div>

            </div>
            <div class="todo" style="overflow: hidden;">
                <div class="head">
                    <h4>Type Ticket Report</h4>
                </div>

                <div id="chartWorkType_top5"></div>


            </div>

        </div>
    </main>
    <!-- MAIN -->
</section>
<!-- CONTENT -->
<script>
$(function() {
    // $('input[name="daterange"]').daterangepicker({
    //     opens: 'left'
    // }, function(start, end, label) {
    //     console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end
    //         .format('YYYY-MM-DD'));
    // });

    $('#filter_Date').daterangepicker({
        startDate: new Date(FILTER_START),
        endDate: new Date(FILTER_END),
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
                .endOf('month')
            ]
        }
    }, function(start, end) {
        FILTER_START = moment(start).format('YYYY-MM-DD H:mm:s');
        FILTER_END = moment(end).format('YYYY-MM-DD H:mm:s');

        // getDataHistoryRequest();
        getdataDashboardTicket();
        DonutDashboard();
        ChartBarDash();
    });

    getdataDashboardTicket();
    DonutDashboard();
    ChartBarDash();
});
</script>