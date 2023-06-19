<!-- CONTENT -->
<script>
$(window).ready(() => {
    // getDataTicketComplete();
    selecthFilterEmp();
})
</script>
<link rel="stylesheet" type="text/css" href="<?=BASEPATH?>include/css/ticket.css">
<section id="content">
    <main>
        <div class="head-title">
            <div class="left">
                <h1>History</h1>
                <ul class="breadcrumb">
                    <li>
                        <a href="#">Dashboard</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>
                        <a class="active" href="#">History</a>
                    </li>
                </ul>
            </div>
        </div>
        <hr>
        <div class="col-md-12">
    <div class="searchTicket mb-2">
        <div class="row gap-3">
            <div class="col-md-3 col-lg-2">
                <label class="ms-3">Search</label>
                <input type="search" class="form-control" placeholder="Type here.." id="searchInputhistory">
            </div>
            <div class="col-md-3 col-lg-2">
                <label class="ms-3">Filter <i class="bi bi-funnel"></i></label>
                <select id="filterHistoryType" onchange="getDataTicketComplete()" class="form-select">
                    <option selected>All</option>
                    <option value="3">Complete</option>
                    <option value="5">Rejected</option>
                </select>
            </div>
            <div class="col-md-3 col-lg-2 <?=getDataUserPermisionByRolesTypeAndSessionToken('ManageTicket') && ('ManageMyJob') ?'':'d-none';?>">
                <label class="ms-3">Employee <i class="bi bi-people"></i></label>
                <select id="ticketfilterHistoryEmp" onchange="getDataTicketComplete()" class="form-select"></select>
            </div>
            <div class="col-md-3 col-lg-2">
                <label class="ms-3">Date</label>
                <input class="form-control" id="reportrange">
            </div>
        </div>
    </div>
</div>

        <div class="show-divHistory pb-5 mt-3" id="showInfoHistory">
        </div>
    </main>
</section>
<script>
function performSearch() {
    var searchValue = document.getElementById("searchInputhistory").value.toLowerCase();
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
document.getElementById("searchInputhistory").addEventListener("keyup", performSearch);
</script>

<script type="text/javascript">
$(function() {
    var datestart = moment().subtract(29, 'days');
    var dateend = moment();

    function cb(datestart, dateend) {
        $('#reportrange span').html(datestart.format('MMMM D, YYYY') + ' - ' + dateend.format('MMMM D, YYYY'));
    }

    $('#reportrange').daterangepicker({
        datestart: new Date(FILTER_START),
        dateend: new Date(FILTER_END),
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
    }, function(datestart, dateend) {
        FILTER_START = moment(datestart).format('YYYY-MM-DD H:mm:s');
        FILTER_END = moment(dateend).format('YYYY-MM-DD H:mm:s');

        getDataTicketComplete();
    });

    // cb(start, end);
});
</script>