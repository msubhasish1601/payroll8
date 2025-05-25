<style>
.top-left .menutoggle {
    color: #fff !important;
    cursor: pointer;
    font-size: 1em;
    height: 33px;
    line-height: 60px;
    width: 83px;
    /* display: block; */
    position: absolute;
    text-align: right;
}
</style>
<header id="header" class="header">
    <div class="top-left">
        <div class="navbar-header">

            <a class="navbar-brand" href="./"><img src="{{ asset('theme/images/payroll-logo.png') }}" alt=""
                    width="83px"></a>
            <a class="navbar-brand hidden" href="./"><img src="{{ asset('images/logo2.png') }}" alt="Logo"></a>
            <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
        </div>
    </div>
    <div class="top-right">
        <div class="hd-name">
            <!-- <h2>BOARD OF PRACTICAL TRAINING (EASTERN REGION)</h2>
                            <h4><span style="font-size: 20px;">Under Ministry of HRD, Government of India</span></h4> -->
        </div>
        <div class="header-menu">
            <div class="user-area dropdown float-right">
                <a style="display: block;overflow: hidden;float:left;padding: 20px 15px 0 0;" class="home"
                    href="{{url('dashboard')}}"><img style="width: 26px;margin-top: 76px;"
                        src="{{ asset('images/home.png') }}" alt="Logo"></a>

                <a title="Logout" style="display: block;overflow: hidden;float:left;padding: 25px 15px 0 0;"
                    class="home" href="{{url('logout')}}"><img src="{{ asset('img/login.png') }}" alt=" " style="margin-top: 66px;width: 30px;"></a>
            </div>
        </div>
    </div>
</header>
