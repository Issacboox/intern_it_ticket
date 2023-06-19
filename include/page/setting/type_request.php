<script>
$(window).ready(() => {
    getdataTypeRequestSwitch();
    getdataSettingResponder();
})
</script>

<style>


    .col-md-9,
    .col-lg-10 {
        width: 75%;
    }

    .col-md-3,
    .col-lg-2 {
        width: 25%;
        margin-top: 0;
        justify-content: flex-end;
    }

</style>
<section id="content">
    <main>
        <div class="head-title">
            <div class="left">
                <div class="d-flex">
                    <button1 class="btn btn-light  pe-3 mb-3 float-start me-4" onclick="history.back()">
                        <i class="bi bi-arrow-left"></i>
                    </button1>
                    <h1>Type Request Setting</h1>
                </div>
                <ul class="breadcrumb">
                    <li>
                        <a href="#">Setting</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>
                        <a class="active" href="#">Type Request</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="mb-5">
            <div class="d-flex flex-wrap gap-4 ms-1">
                <div class="col-md-5 mt-2">
                    <div class="Switch-btn-type">
                        <div class="d-flex gap-2">
                            <div class="col-md-10 mt-1">
                                <h5><i class="bi bi-gear"></i> Ticket type management <i class="bi bi-square-fill" style="color:#69fd0d"></i> Visible | <i class="bi bi-square-fill" style="color:#d385dd"></i> On/Off</h5>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-light float-end" onclick="add_type_request(0)"><i
                                        class="bi bi-plus-square"></i></button>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-12">
                            <div class="d-flex gap-3" style="margin-left:72%">
                                
                            </div>
                        </div>
                        <div class="setting" id="show-type">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-2 reponderSetting">
                    <div class="Switch-btn-type">
                        <div class="d-flex gap-2">
                            <div class="col-md-10 mt-1">
                                <h5><i class="bi bi-person-gear"></i> Manage responder</h5>
                            </div>
                            <div class="col-md-2 mt-1">
                                <button class="btn btn-primary float-end me-1" onclick="saveResponderSetting(0)">
                                    <i class="bi bi-life-preserver"></i> Save
                                </button>
                            </div>
                        </div>
                        <hr>
                        <div class="responder">
                            <table class="table">
                                <thead style="background-color:#EBDEF0">
                                    <tr>
                                        <th scope="col" class="col-md-6" style="width:20%">Type</th>
                                        <th scope="col" class="col-md-6" style="width:80%">Responder</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-responder"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </main>

</section>
