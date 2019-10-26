window.component = null;
function reload () {
    let resourceName = resourceGetted ? resourceGetted : "";
    function createWith (classname) {
        if (window.component == null) {
            window.component = new classname ();
            if (window.component.controller) window.component.controller ();
        }
        return window.component;
    }
    switch (resourceName) {
        case "usuarios":
            let users = [];
            handleUsers.getUsers()
            .then (function (xhr) {
                users = JSON.parse (xhr.responseText);
                let divName = "content-list";
                let div = document.getElementById (divName);
                if (!div)
                    return;
                while (div.lastElementChild) {
                    div.removeChild (div.lastElementChild);
                }

                handleUsers.printUsers (divName, users);
            })
            .catch (function (xhr) {
                console.log (xhr);
            });
            break;
        case "":
            console.log (AlbumListComponent);
            albumlist = createWith (AlbumListComponent);
            albumlist.render();
            break;
        case "eddal":
            album = createWith (AlbumComponent);
            album.render();
            break;
        case "edd":
            createWith (FanpageComponent);
            window.component.render();
            break;
        case "pp":
            createWith (ProgrammedComponent);
            window.component.render();
            break;
        case "instagram":
            createWith (InstagramListComponent);
            window.component.render();
            break;
        default: break;
    }
}
function passthrough () {
    $(".drop-on-hover").mouseenter (function (ev) {
        //$(ev.target).dropdown("toggle");
    });
}
function globalTopbarScrolling () {
    var c = $(".topbar"),
        b = $(".ic-topbar-logo img");
    var a = function() {
        if ($(window).scrollTop() > 0) {
            if (!c.hasClass("status-levitate")) {
                c.delay(200).addClass("status-levitate");
                
            }
        } else {
            if (c.hasClass("status-levitate")) {
                c.delay(200).removeClass("status-levitate")
            }
        }
    };
    $(document).ready(a);
    $(window).on("scroll resize", function() {
        a()
    })
};
document.addEventListener ("DOMContentLoaded", function () {
    reload();
    passthrough();
    globalTopbarScrolling();
});