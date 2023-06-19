<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/searchpanes/2.1.2/js/dataTables.searchPanes.min.js"></script>
<script src="https://cdn.datatables.net/select/1.6.2/js/dataTables.select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/searchpanes/2.1.2/css/searchPanes.bootstrap5.min.css" />

<script>
$(window).ready(() => {
    getdataCardSetting();
    // getdataCardTypeSelect();
});

</script>

<style>
    .table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 40px;
}

.table td {
  padding: 7px 10px;

}

.word-break {
  word-break: break-all;
}

.scroll-container {
  overflow: auto;
  margin-bottom: 40px;
  border-left: 1px solid;
  border-right: 1px solid;
}

.scroll {
  margin: 0;
}

.scroll td:first-of-type {
  position: sticky;
  left: 0;
  border-left: none;
  font-weight: bold;
  
  &:after {
    content: "";
    position: absolute;
    top: 0;
    right: -1px;
    height: 100%;
    width: 1px;

  }
}

.scroll td:last-of-type {
  border-right: none;
}

@media screen and (max-width: 600px) {  
  .responsive thead {
    visibility: hidden;
    height: 0;
    position: absolute;
  }
  
  .responsive tr {
    display: block;
    margin-bottom: .625em;
  }
  
  .responsive td {
    border-bottom: none;
    display: block;
    font-size: .8em;
    text-align: right;
  }
  
  .responsive td::before {
    content: attr(data-label);
    float: left;
    font-weight: bold;
    text-transform: uppercase;
  }
  

}
</style>
<section id="content">
    <main>
        <div class="head-title">
            <div class="left">
                <div class="d-flex">
                    <button1 class="btn btn-light  pe-3 mb-3 float-start me-4 mt-1" onclick="history.back()">
                        <i class="bi bi-arrow-left"></i>
                    </button1>
                    <h1>Suggest Card Setting</h1>
                </div>
                <ul class="breadcrumb">
                    <li>
                        <a href="#">Setting</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>
                        <a class="active" href="#">Sugestion card</a>
                    </li>
                </ul>
            </div>
            <div class="float-end mb-3">
                <button type="button" class="btn btn-success btn-sm" onclick="createCardGuide(0)">
                    Add card guide <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </div>

        <hr>
        <div class="modal fade modal-lg" id="modal-addCardGuide" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Create Guide</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="body-addCardGuide">

                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary float-end" onclick="addGuideCard(0)">Add</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="suggestCardtable" id="tableCardcustom">
            <table class="table responsive" id="table-tableCardcustom" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col" style="width:1%">ID</th>
                        <th scope="col" style="width:2%">For type</th>
                        <th scope="col" style="width:15%">Title</th>
                        <!-- <th scope="col" style="width:40%">Description</th> -->
                        <!-- <th scope="col" style="width:40%">Solution</th> -->
                        <th scope="col" style="width:1%">Edit</th>
                    </tr>
                </thead>
                <tbody id="tbody-guideInfoCard"></tbody>
            </table>
        </div>

        
    </main>
    <!-- MAIN -->
</section>


<!-- CONTENT -->