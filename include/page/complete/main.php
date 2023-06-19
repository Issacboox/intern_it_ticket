<!-- CONTENT -->

<section id="content">
    <main>
        <!-- MAIN -->
        <div class="head-title">
            <div class="left gap-3">
                <h1>
                    <button1 class="btn btn-light " onclick="history.back()">
                        <i class="bi bi-arrow-left"></i>
                    </button1>&nbsp;&nbsp;Complete Work
                </h1>
                <hr>

            </div>
        </div>
        <div class="d-flex gap-2 mt-2">
            <div class="col-md-4">
                <div class="cardcustom col-md-12">
                    <div class=" col-md-3 " style="align-item:center">
                        <h6>User Info</h6>
                        <img src="https://w7.pngwing.com/pngs/340/946/png-transparent-avatar-user-computer-icons-software-developer-avatar-child-face-heroes-thumbnail.png"
                            width="60px" style="border-radius:50%">
                    </div>
                    <div class=" col-md-8 ">
                        IT | 759
                        <br> Julladit Kheawrungreuang

                    </div>
                </div>
            </div>
            <div class=" col-md-8">
                <div class="cardcustom col-md-12">
                    <div class=" col-md-1" style="align-item:center">
                        <h6>Problem</h6>
                        <img src="https://cdn-icons-png.flaticon.com/512/305/305098.png" width="60px"
                            style="border-radius:50%">
                    </div>
                    <div class=" col-md-10">
                        <p class="${array_status_class[card.request_status]} float-end">
                            Status here</p>
                        Date here | Time here
                        <br> Detail here
                        ...................
                    </div>
                </div>
            </div>

        </div>
        <br>
        <div class="report">
            <div class="col-md-12">
                <form1 method="POST" action="insert_prob.php" autocomplete="off" enctype="multipart/form-data">
                    <h5>Overall operation</h5>
                    <label class="mt-1">Evaluate performance</label>
                    <textarea class="form-control mt-2" placeholder="Type here" name="prob_desc" required
                        rows="4"></textarea><br>
                    <a href="" class="btn btn-info"> Problem Solve </a>
                    <a href="" class="btn btn-warning">Forward to other </a>
                    <a href="" class="btn btn-success"> Update user info </a>
                </form1>
            </div>

    </main>
    <!-- MAIN -->
</section>
<!-- CONTENT -->