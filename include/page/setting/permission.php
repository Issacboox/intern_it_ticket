<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/searchpanes/2.1.2/css/searchPanes.bootstrap5.min.css" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/searchpanes/2.1.2/js/dataTables.searchPanes.min.js"></script>
<script src="https://cdn.datatables.net/select/1.6.2/js/dataTables.select.min.js"></script>

<script>
$(window).ready(() => {
    getDataEmpPermission();

});
</script>
<style>
html {
    overflow: hidden;
}
@media (max-width: 768px) {
  .col-sm-12 {
    flex-basis: 100% !important;
    max-width: 100% !important;
  }
  .col-md-5 {
    flex: 0 0 auto;
    width: 100%;
}

  .float-end {
    float: none !important;
    display: block;
    text-align: right;
    margin-bottom: 10px;
  }

  .settingPerformobile {
    text-align: left;
    margin-left: 0;
  }

  .permissionImg {
    margin-left: auto;
    margin-right: auto;
    display: block;
    max-width: 100%;
    height: auto;
  }
}

@media (max-width: 1440px) {
  /* Add any additional responsive styles for larger screens here */
  .col-md-4 {
    flex: 0 0 auto;
    width: 33.33333333%;
    /* margin-left: 26%; */
    text-align: left;}
    
}


</style>
<section id="content">
    <main>
        <!-- MAIN -->

        <div class="head-title">
            <div class="left">
                <div class="d-flex">
                    <button class="btn btn-light  pe-3 mb-3 float-start me-4" onclick="history.back()">
                        <i class="bi bi-arrow-left"></i>
                    </button>
                    <h1>Permision</h1>
                </div>
                <ul class="breadcrumb">
                    <li>
                        <a href="#">Setting</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>
                        <a class="active" href="#">Permission</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="bg-tablePermission" id="permissionAll">
            <div class="col-md-12 bg-empList">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table responsive" id="table-permissionAll" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col" >Code</th>
                                    <th scope="col" >Employee Name</th>
                                    <th scope="col" >Department</th>
                                    <th scope="col" >Section</th>
                                    <th scope="col" >Email</th>
                                    <!-- <th scope="col" style="width:6%">Status</th> -->
                                    <th scope="col" style="width:7%">Manage</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-permissionEmp">
                                <!-- Add your HTML markup here if needed -->
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </main>
    <!-- MAIN -->
</section>
<!-- CONTENT -->