<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
<script src="https://cdn.jsdelivr.net/npm/moment@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker@latest"></script>

<script>
$(window).ready(() => {

})
</script>

<section id="content">
    <main id="loadingDiv">
        <div class="head-title">
            <div class="left col-md-12">
                <h1>My Job</h1>
                <div class="dropdown float-end">
                    <button1 class="btn btn-light " onclick="history.back()">
                        <i class="bi bi-arrow-left"></i>
                    </button1>
                    <button class="btn btn-light " type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-sort-down">&nbsp;</i> My job
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="<?=BASEPATH?>Assign"><button class="dropdown-item" type="button">All
                                    Ticket</button></a></li>
                        <li><a href="<?=BASEPATH?>inprocess"><button class="dropdown-item" type="button">My
                                    Job</button></a></li>
                    </ul>

                </div>
                <ul class="breadcrumb">
                    <li>
                        <a href="<?=BASEPATH?>Assign">Dashboard</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>
                        <a href="<?=BASEPATH?>Assign">Ticket</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>
                        <a class="active" href="<?=BASEPATH?>inprocess#">My job</a>
                    </li>
                </ul>
            </div>
        </div>
        <hr>
        <div class="mb-4">
            <div class="searchTicket mb-">
                <div class="row align-items-center">
                    <div class="col-md-3 col-lg-2">
                        <label class="">Search</label>
                        <input type="search" class=" form-control" placeholder="Type here.." id="SeachMyjob">
                    </div>
                    <div class="col-md-3 col-lg-2">
                        <label class="">Filter </label>
                        <select id="filterstatus" onchange="getDataInprocessWork()" class="form-select">
                            <option selected>All</option>
                            <option value="2">Assigned</option>
                            <option value="4">Inprocess</option>
                            <option value="Complete">Complete only</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-lg-2">
                        <label class="">Date</label>
                        <input type="text" class="form-control" id="reportrange">

                    </div>


                </div>
            </div>
        </div>

        <div class="show-divHistory pb-5" id="show-inprocessWork"> </div>




    </main>
</section>

<script>
function performSearch() {

    var searchValue = document.getElementById("SeachMyjob").value.toLowerCase();
    var elementsToSearch = document.getElementsByClassName("box work mb-3");
    for (var i = 0; i < elementsToSearch.length; i++) {
        var element = elementsToSearch[i];
        var elementText = element.textContent || element.innerText;
        if (elementText.toLowerCase().includes(searchValue)) {
            element.style.display = "block";
        } else {
            element.style.display = "none";
        }
    }
}
document.getElementById("SeachMyjob").addEventListener("keyup", performSearch);
</script>

<script type="text/javascript">

$(function() {
    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

    $('#reportrange').daterangepicker({
        startDate: new Date(FILTER_START),
        endDate: new Date(FILTER_END),
        drops: 'auto',
                "locale": {
                    "format": "DD/MM/YY",
                    "separator": " ถึง ",
                    "applyLabel": "ตกลง",
                    "cancelLabel": "ยกเลิก",
                    "fromLabel": "จาก",
                    "toLabel": "ถึง",
                    "customRangeLabel": "เลือกช่วงเวลาเอง",
                    "weekLabel": "W",
               
                    "firstDay": 0
                },
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

        getDataInprocessWork();
    });


    getDataInprocessWork();
    // cb(start, end);
});
</script>