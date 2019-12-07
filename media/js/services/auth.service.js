{
class AuthService extends amazonia.etiqueta {
    user = null;
    launchAuth = false;
    session () {
        let session = new MirrorHandler(ajax, { }, 'resources/session');
        session.query(session.selectQuery())
        .then ((xhr) => {
            console.log (xhr);
        })
        .catch ((xhr) => {
            console.log (xhr);
        });
    }
}
window.AuthService = new AuthService();
}