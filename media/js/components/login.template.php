<div class="container main">
    <div am-if="this.iff">
        aslkdjaslkjd
    </div>
    <div class="d-flex justify-content-center h-100">
        <div class="card">
            <div class="card-header">
                <h3>{{this.nombre}}</h3>
                <div class="d-flex justify-content-end social_icon">
                    <span><i class="fab fa-facebook-square"></i></span>
                    <span><i class="fab fa-google-plus-square"></i></span>
                    <span><i class="fab fa-twitter-square"></i></span>
                </div>
            </div>
            <div class="card-body">
                <form id="formLogin" am-submit="this.login()">
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input am-model="this.user.data.account" type="text" class="form-control" placeholder="Usuario">
                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input am-model="this.user.data.password" type="password" class="form-control" placeholder="Contraseña">
                    </div>
                    <div class="row align-items-center remember">
                        <input type="checkbox" am-model="this.remember">Recuérdame
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Login" class="btn float-right login_btn">
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-center links">
                    Don't have an account?<a href="#">Sign Up</a>
                </div>
                <div class="d-flex justify-content-center">
                    <a href="#">Forgot your password?</a>
                </div>
            </div>
        </div>
    </div>
</div>