<section id="content">
    <!-- MAIN -->
    <main>
        <!-- <div class="head-title">
            <div class="left col-md-12">
                <h1><img class="imgGifforAll"
                        src="https://media0.giphy.com/media/kinlAqef3yqTIj9PyB/giphy.gif?cid=6c09b9527fb75b33e6639b97c83a8cbe2785baadb533ec90&ep=v1_internal_gifs_gifId&rid=giphy.gif&ct=s"
                        width="3%"> Create Ticket</h1>
                <p>Please select type and fill form</p>
            </div>
        </div>

        <hr> -->

        <div class="row">
            <div class="boxRequestCustom">
                <div class="" id="App-formrequest">
                    <div class="head-title">
                        <div class="left col-md-12">
                            <h1><img class="imgGifforAll"
                                    src="https://media0.giphy.com/media/kinlAqef3yqTIj9PyB/giphy.gif?cid=6c09b9527fb75b33e6639b97c83a8cbe2785baadb533ec90&ep=v1_internal_gifs_gifId&rid=giphy.gif&ct=s"
                                    width="3%"> Create Ticket</h1>
                            <p>Please select type and fill form</p>
                        </div>
                    </div>

                    <hr>
                    <div class="">
                        <div class="row radio-buttons" id="typeRequest"></div>
                    </div>
                    <div class="row ">
                        <div class="col-md-12">
                            <label style="color:red" class="d-none">&#42;Fill out the form to request computer repair.
                                Including
                                issues with various software programs that the IT department is in charge of
                                (approximate
                                time to respond is 4 hours)</label><br>
                            <label class="mb-3"><i class="bi bi-arrow-return-right"></i> Please specify the problem
                                <label style="color:red">&#42;</label>
                            </label>
                            <input type="search" name="problem" id="problem" class="form-control customInputSubject"
                                placeholder="Type here.." required>
                        </div>
                        <!-- <div class="col-md-12">
                        <div class="head-guide">
                            <h5 class="mt-1"><img class="mt-1"
                                    src="https://cdn-icons-png.flaticon.com/512/5649/5649619.png" style="width:3%">
                                Guide Info</h5>
                            <span>
                                You can view the details of general fixes that you can perform without waiting for a
                                response by
                                clicking. I hope this area has assisted you in resolving some issues. and if none of the
                                guide cards have the
                                topic you're searching for, please open a ticket and we'll fix it for you.</span>
                        </div>
                    </div> -->

                        <div class="col-md-12 showResult d-none" id="showResult">
                            <ul class="box-info" id="showguide"></ul>
                        </div>
                        <div class="col-md-12 probleminput" id="problemDescedit">
                            <div class="col-md-12">
                                <label class="mt-4 mb-3"><i class="bi bi-arrow-return-right"></i> Problem Description
                                    <label style="color:red">&#42;</label>
                                </label>
                                <textarea class="form-control" name="prob_desc" id="problem-desc" required
                                    rows="5"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="mt-4 mb-3"><i class="bi bi-arrow-return-right"></i> Request Urgent</label>

                            <div class="row">
                                <div class="col-6 pe-1">
                                    <input class="SelectYesno" type="radio" name="rqurgent" id="rqurgent1" checked
                                        value="0">
                                    <label class="inputEmp" for="rqurgent1"><i class="fas fa-times-circle"></i>
                                        No</label><br>
                                </div>
                                <div class="col-6 ps-1">
                                    <input class="SelectYesno" type="radio" name="rqurgent" id="rqurgent" value="1">
                                    <label class="inputEmp" for="rqurgent"><i class="fas fa-check-circle"></i>
                                        Yes</label><br>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <div class="cardforselectemp" id="div-urgentDate"
                                        style="display: none; width:100%;">
                                        <!-- <p style="color:red;">**In case need to repair this right away and it cannot wait**</p> -->
                                        <input type="datetime-local" name="urgentDate" id="urgentDate"
                                            class="form-control" placeholder="Type here.." required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 <?=getDataUserPermisionByRolesTypeAndSessionToken('ManageMyJob') ? '' : 'd-none';?>">
                            <label class="mt-4 mb-3"><i class="bi bi-arrow-return-right"></i> Create ticket for another
                                person</label>
                            <div class="row">
                                <div class="col-6 pe-1">
                                    <input class="SelectYesno" type="radio" name="ticketOt" checked id="ticketOt1"
                                        value="0">
                                    <label class="inputEmp" for="ticketOt1"><i class="fas fa-times-circle"></i>
                                        No</label><br>
                                </div>
                                <div class="col-6 ps-1">
                                    <input class="SelectYesno" type="radio" name="ticketOt" id="ticketOt" value="1">
                                    <label class="inputEmp" for="ticketOt"><i class="fas fa-check-circle"></i>
                                        Yes</label><br>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <div class="cardforselectemp" id="div-selectAnotherEmp" style="width:100%;">
                                        <!-- <p style="color:red;">**In case you create ticket for another user***</p> -->
                                        <select class="filterEmp" name="selectAnotherEmp" id="selectAnotherEmp"
                                            style="width:100%; display:none"></select>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <label class="mt-4"><i class="bi bi-arrow-return-right"></i> Upload File / Images</label>
                        <div class="col-md-6">
                            <div class="boxs">
                                <div class="input-box">
                                    <input type="file" id="AttachmentRequest" multiple
                                        accept="image/*,.doc,.docx,.pdf,application/msword,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                        hidden>
                                    <label for="AttachmentRequest" class="uploadlable">
                                        <span><i class="bi bi-file-earmark-arrow-up"></i></span>
                                        <p>Attachment</p>
                                    </label>
                                </div>
                            </div>

                            <div id="filewrapper" class="mt-3">
                                <h5 class="uploaded">Uploaded Documents</h5>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3 text-end ">
                            <button type="submit" name="btn2" onclick="submit_ReportProblem()"
                                class="submit me-md-2 md-4 text-end">
                                <i class="fas fa-paper-plane"></i> Create Ticket
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </main>
    <!-- MAIN -->
</section>

<!-- CONTENT -->
<script src="<?=BASEPATH?>include/js/report.js"></script>
<script>
$(window).ready(() => {
    getDataTypeRequest();
    getCardGuide();
    // getTextEditorDesc();
    createTextEditor('problem-desc');
    SelectDuedate();
    selectEmpTicket();
    // saveChangeBtn()
})

function showSelect() {
    const ticketOtRadioYes = document.getElementById('ticketOt');
    const selectAnotherEmp = document.getElementById('div-selectAnotherEmp');

    selectAnotherEmp.style.display = ticketOtRadioYes.checked ? 'block' : 'none';
}

document.addEventListener('DOMContentLoaded', function() {
    const ticketOtRadioYes = document.getElementById('ticketOt');
    const ticketOtRadioNo = document.getElementById('ticketOt1');

    ticketOtRadioYes.addEventListener('change', showSelect);
    ticketOtRadioNo.addEventListener('change', showSelect);

    showSelect();
});

function searchselect() {
    $(document).ready(function() {
        $('filterEmp').select2();
    });
}
</script>