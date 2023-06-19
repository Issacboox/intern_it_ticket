<!-- CONTENT -->
<section id="content">

    <!-- MAIN -->
    <main>
      

        <div class="row" id="userInfo"></div>
          
        <div class="ass mt-4">
            <h5>Assign tasks</h5>
            <h6>Type</h6>
            <div class="radio-buttons" id="typeRequest"></div>
        </div>
        <!-- <div class="row">
            <div class="col-md-12">
                <h6>Assign work</h6>
                <div class="row">

                    <div class="col-md-4">
                        <div class="cardcustom">
                            <div class="row">
                                <div class="col-md-3">
                                    <img src="https://ps.w.org/user-avatar-reloaded/assets/icon-256x256.png?rev=2540745"
                                        alt="User Image" style="width: 75px; border-radius: 50%;">
                                </div>
                                <div class="col-md-9">
                                    <div class=" text-center">

                                        <div class="row">
                                            <div class="col-md-12">
                                                Employee name :
                                            </div>

                                            <div class="col-4">
                                                <div class="box current">

                                                    <div class="num text-align:center"></div>
                                                    1
                                                    <div class="texts">
                                                        Current
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="box started ">

                                                    <div class="num text-align:center">
                                                        2
                                                    </div>
                                                    <div class="texts">
                                                        Started
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="box plan">

                                                    <div class="num text-align:center">
                                                        0
                                                    </div>
                                                    <div class="texts">
                                                        Plan
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="cardcustom">
                            <div class="row">
                                <div class="col-md-3">
                                    <img src="https://toppng.com/uploads/preview/avatar-png-11554021661asazhxmdnu.png"
                                        alt="User Image" style="width: 75px; border-radius: 50%;">
                                </div>
                                <div class="col-md-9">
                                    <div class=" text-center">

                                        <div class="row">
                                            <div class="col-md-12">
                                                Employee name :
                                            </div>

                                            <div class="col-4">
                                                <div class="box current">

                                                    <div class="num text-align:center"></div>
                                                    1
                                                    <div class="texts">
                                                        Current
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="box started ">

                                                    <div class="num text-align:center">
                                                        2
                                                    </div>
                                                    <div class="texts">
                                                        Started
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="box plan">

                                                    <div class="num text-align:center">
                                                        0
                                                    </div>
                                                    <div class="texts">
                                                        Plan
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="cardcustom">
                            <div class="row">
                                <div class="col-md-3">
                                    <img src="https://www.pngall.com/wp-content/uploads/12/Avatar-Profile-PNG-Picture.png"
                                        alt="User Image" style="width: 75px; border-radius: 50%;">
                                </div>
                                <div class="col-md-9">
                                    <div class=" text-center">

                                        <div class="row">
                                            <div class="col-md-12">
                                                Employee name :
                                            </div>

                                            <div class="col-4">
                                                <div class="box current">

                                                    <div class="num text-align:center"></div>
                                                    1
                                                    <div class="texts">
                                                        Current
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="box started ">

                                                    <div class="num text-align:center">
                                                        2
                                                    </div>
                                                    <div class="texts">
                                                        Started
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="box plan">

                                                    <div class="num text-align:center">
                                                        0
                                                    </div>
                                                    <div class="texts">
                                                        Plan
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div> -->

            <div class="col-md-12">
                <label class="mt-2">Remark</label>
                <textarea class="form-control mt-2" placeholder="type here..."></textarea>
            </div>
            <div class="col-md-12" style="text-align: right;">
                <button class="assignbtn">Assign</button>
            </div>

    </main>
    <!-- MAIN -->
</section>
<!-- CONTENT -->
<script>
$(window).ready(() => {
    getDataTypeRequestForAdmin('<?=$token?>');
    // getDataFormRequest('<?=$token?>');
})
</script>