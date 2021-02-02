<script src="<?php echo AppPath ?>/public/dangky/dangkyServices.js" type="text/javascript"></script>
<script src="<?php echo AppPath ?>/public/dataclient/dataclientController.js" type="text/javascript"></script>
<div class="container" ng-controller="dataclientController" >
    <div class="row">
        <div class="col-4" ></div>
        <div class="col-4" >
            <h1 class="text-center" >Đăng Nhập</h1>
            <form action="" method="post">
                <div class="form-group has-feedback">
                    <input type="text" ng-model="Username" name="Username" class="form-control" placeholder="Tài khoản" />
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" ng-model="Password" name="Password" class="form-control" placeholder="Password" />
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div hidden class="hidden form-group has-feedback">
                    <input type="password" name="Key2fa" class="form-control" placeholder="Key2fa" />
                    <span class="glyphicon glyphicon-cloud form-control-feedback"></span>
                </div>
                <div class="row ">
                    <div hidden="" class="col-xs-8 hidden">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox"> Remember Me
                            </label>
                        </div>
                    </div> 
                    <div class="col-3"></div>
                    <div class="col-6 text-center">
                        <button type="button" ng-click="clickLogin()" class="btn btn-lg btn-color btn-button">Đăng Nhập</button>
                    </div> 
                </div>
            </form>    
        </div>

        <div hidden="" class="social-auth-links text-center hidden">
            <p>- OR -</p>
            <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
            <a href="#" class="btn btn-block btn-social btn-google-plus btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
        </div>
        <br>
        <div class="col-12" >
            <div class="row" >
                <div class="col-2" ></div>
                <div class="col-8 " >
                    <div class="row" >

                        <a href="/user/index/resetpassword/" class="col-6 " >Quên Mật Khẩu</a> 
                        <a href="/user/index/register/" class="col-6 text-right" >Đăng Ký Thành Viên</a> 

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>