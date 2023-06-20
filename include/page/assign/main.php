<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
<script src="https://cdn.jsdelivr.net/npm/moment@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker@latest"></script>
<!-- CONTENT -->
<script>
$(window).ready(() => {

    getDataEmpDashboard()
    // filterDates() 
    selectFilterEmp();

    // getDataHistoryRequest();
})
</script>
 <?php 
// print_r(getDataUserPermisionByRolesTypeAndSessionToken('ManageTicket'));
 ?>
<section id="content">
    <!-- MAIN -->
    <main id="loadingDiv">

        <div class="head-title" >
            <div class="left col-md-12">
                <h1><img  class="imgGifforAll" src="https://media0.giphy.com/media/kinlAqef3yqTIj9PyB/giphy.gif?cid=6c09b9527fb75b33e6639b97c83a8cbe2785baadb533ec90&ep=v1_internal_gifs_gifId&rid=giphy.gif&ct=s"
                        width="3%"> All Ticket</h1>
                        <div class="dropdown float-end gap-2 <?=getDataUserPermisionByRolesTypeAndSessionToken('ManageMyJob') ?'':'d-none';?>">

                    <button class="btn btn-light " type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-sort-down">&nbsp;</i> All Ticket
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="<?=BASEPATH?>Assign"><button class="dropdown-item" type="button">All
                                    Ticket</button></a></li>
                        <li><a href="<?=BASEPATH?>inprocess"><button class="dropdown-item"
                                    type="button">MyJob</button></a></li>
                    </ul>
                </div>
                <ul class="breadcrumb">
                    <li>
                        <a href="#">Dashboard</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>
                        <a class="active" href="#">Ticket</a>
                    </li>
                </ul>
            </div>
        </div>
        <hr>

        <ul class="boxdash <?=getDataUserPermisionByRolesTypeAndSessionToken('ManageTicket') ?'':'d-none';?>" id="empdash">
        </ul>


        </div>

        <div class="mb-4">
            <div class="searchTicket mb-">
                <div class="row align-items-center">
                    <div class="col-md-3 col-lg-2">
                        <label class="">Search</label>
                        <input type="search" class=" form-control" placeholder="Type here.." id="searchInput">
                    </div>
                    <div class="col-md-3 col-lg-2">
                        <label class="">Filter </label>
                        <select id="ticketfilterType" onchange="getDataHistoryRequest()" class="form-select">
                            <option selected>All</option>
                            <option value="2">Assigned</option>
                            <option value="4">Inprocess</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-lg-2 <?=getDataUserPermisionByRolesTypeAndSessionToken('ManageMyJob') ?'':'d-none';?>">
                        <label class="">Employee </label>
                        <select id="ticketfilterEmp" onchange="getDataHistoryRequest()" class="form-select"></select>
                    </div>
                    <div class="col-md-3 col-lg-2">
                        <label class="">Date</label>
                        <input type="text" class="form-control" id="reportrange">
                        <!-- <div id="reportrange"
                            style="width: fit-content;background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; border-radius: 5px; border-color: #dfdfdf;">
                            <i class="fa fa-calendar"></i>&nbsp;
                            <span></span> <i class="fa fa-caret-down"></i>
                        </div> -->
                    </div>


                </div>
            </div>
        </div>

        <div class="show-divHistory pb-5" id="show-divHistory">
        </div>
    </main>
    <!-- MAIN -->
</section>
<!-- CONTENT -->

<script>
function performSearch() {

    var searchValue = document.getElementById("searchInput").value.toLowerCase();
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
document.getElementById("searchInput").addEventListener("keyup", performSearch);


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

        getDataHistoryRequest();
    });

    // cb(start, end);
});

</script>