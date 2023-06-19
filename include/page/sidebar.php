    <!-- SIDEBAR -->
    <script>
        $(window).ready(() => {
        });
    </script>
    <style>

    </style>
    <section id="sidebar" class="hide">
        <a href="<?=getDataUserPermisionByRolesTypeAndSessionToken('DashboardAdmin') ?'<?=BASEPATH?>home':'';?>" class="brand" style="gap:10px;">
            <!-- <i class='bx bxs-smile'></i> -->
            <img src="<?=BASEPATH?>include\page\ticket.jpg" width="11%" class="mt-2 ms-3 me-2 customLogo">
            <span class="text mt-2">Ticket System</span>
            </a>
        <ul class="side-menu top">
            <li class="menu-item" data-menu="<?=BASEPATH?>home">
                <a href="<?=BASEPATH?>home">
                    <i class='bx bxs-home bx-tada-hover'></i>
                    <span class="text">home</span>
                </a>
            </li>
            <li class="menu-item" data-menu="<?=BASEPATH?>create">
                <a href="<?=BASEPATH?>create">
                    <i class='bx bxs-report bx-tada-hover'></i>
                    <span class="text">Create Ticket</span>
                </a>
            </li>
            <li class="menu-item" data-menu="<?=BASEPATH?>Assign">
                <a href="<?=BASEPATH?>Assign ">
                    <i class='bx bxs-coupon bx-tada-hover'></i>
                    <span class="text">Ticket</span>
                </a>
            </li>
            
            <li class="menu-item" data-menu="<?=BASEPATH?>history">
                <a href="<?=BASEPATH?>history">
                    <i class='bx bxs-bell bx-tada-hover'></i>
                    <span class="text">History</span>
                </a>
            </li>
<!--             
            <li class="menu-item" data-menu="<?=BASEPATH?>access">
                <a href="<?=BASEPATH?>access">
                    <i class='bx bxs-lock-open bx-tada-hover'></i>
                    <span class="text">Request Access</span>
                </a>
            </li>
            <li class="menu-item" data-menu="<?=BASEPATH?>borrow">
                <a href="<?=BASEPATH?>borrow">
                    <i class='bx bxs-chevrons-right bx-tada-hover'></i>
                    <span class="text ">Borrow Equipment</span>
                </a>
            </li> -->
           
            <li class="menu-item <?=getDataUserPermisionByRolesTypeAndSessionToken('SettingPage')?'':'d-none';?>" data-menu="<?=BASEPATH?>setting">
                <a href="<?=BASEPATH?>setting ">
                    <i class='bx bxs-cog bx-tada-hover'></i>
                    <span class="text">Settings</span>
                </a>
            </li>
            <li>
                <a href="#" class="logout btn-signout">
                    <i class='bx bxs-log-out-circle bx-tada-hover'></i>
                    <span class="text">Logout</span>
                </a>
            </li>
        
    </section>
    <!-- SIDEBAR -->