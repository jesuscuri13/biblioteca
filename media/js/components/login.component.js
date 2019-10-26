{
class Tag extends amazonia.etiqueta {
    constructor () {
        super();
        this.ruta = "media/js/components/login.template.php";
        console.log (ajax);
    }

    controller () {
        this.nombre = "login";
        this.texto = "feo";
        this.user = {
            account: '',
            password: '',
            remember: false
        };

        this.user = new MirrorHandler(ajax, { account: '', password: '', remember: false }, 'resources/session');
        this.user.initialice();
    }
    
    login () {
        this.user.create (this.user.createQuery())
        .then (function (xhr) {
            console.log (xhr);
        })
        .catch (function (xhr) {
            console.log (xhr);
        });
		return false;
	}
    
    login2 () {
        ajax.post('rest.php', { res: 'rsession', uname: this.user.account, passw: this.user.password })
        .then (function (xhr) {
            console.log (xhr);
        })
        .catch (function (xhr) {

        });
        console.log (this.user);
    }
}

amazonia.apps["super"].etiquetas.push({
    nombre: "app-login",
    create: Tag
});
}