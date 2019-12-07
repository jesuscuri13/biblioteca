{
class Tag extends amazonia.etiqueta {
    constructor () {
        super();
        this.ruta = "media/js/components/login.template.php";
    }

    controller () {
        this.nombre = "login";
        this.texto = "feo";
        this.remember = false;

        this.user = new MirrorHandler(ajax, { account: '', password: '' }, 'resources/session');
        this.user.initialice();
    }

    $init() {
        AuthService.session();
    }
    
    login () {
        this.user.create (this.user.createQuery())
        .then (function (xhr) {
            let response = JSON.parse (xhr.responseText);
            response.user
            console.log (xhr);
        })
        .catch (function (xhr) {
            let response = JSON.parse(xhr.responseText);
            
            console.log (response.error);
        });
		return false;
	}
    
}

amazonia.apps["super"].etiquetas.push({
    nombre: "app-login",
    create: Tag
});
}