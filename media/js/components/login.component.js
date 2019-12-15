{
class Tag extends amazonia.etiqueta {
    constructor () {
        super();
        this.ruta = "media/js/components/login.template.php";
    }

    controller () {
        this.nombre = "Login";
        this.texto = "feo";
        this.remember = false;

        this.user = new MirrorHandler(ajax, { account: '', password: '' }, 'resources/session');
        this.user.initialice();

        this.iff = false;
        this.repeated = ['asds', '23213'];
    }

    $init() {
        AuthService.session();
    }
    
    login () {
        console.log (this.user);
        /*this.user.create (this.user.createQuery())
        .then (function (xhr) {
            let response = JSON.parse (xhr.responseText);
            response.user
            console.log (xhr);
        })
        .catch (function (xhr) {
            let response = JSON.parse(xhr.responseText);
            
            console.log (response.error);
        });
		return false;*/
	}
    
}

amazonia.apps["super"].etiquetas.push({
    nombre: "app-login",
    create: Tag,
    ruta: "media/js/components/login.template.php"
});
}