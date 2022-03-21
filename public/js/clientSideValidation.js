// Clientside Validierung
window.addEventListener("load", function () {

    document.querySelector('form').addEventListener('submit', function (evt) {

        var errors = false;
        var warnings = document.querySelectorAll(".warning");
        if (warnings != null) {
            warnings.forEach(element => {
                element.remove();
            });
        }


        if (document.querySelector('#name') != null) {
            if (document.querySelector('#name').value.trim() === '') {
                document.querySelector('#name').insertAdjacentHTML("afterend", "<label class=\"warning\"> Bitte gib einen Namen ein</label>");
                errors = true;
            }
        }

        if (document.querySelector('#email') != null) {
            if (document.querySelector('#email').value.trim() === '' || !document.querySelector('#email').value.trim().includes("@")) {
                document.querySelector('#email').insertAdjacentHTML("afterend", "<label class=\"warning\"> Bitte gib eine gültige Email ein.</label>");
                errors = true;
            }
        }

        if (document.querySelector('#telefon') != null) {
            if (document.querySelector('#telefon').value.trim() === '' || (document.querySelector('#telefon').value.includes("/[^0-9\/()\+\-\s]/g"))) {
                document.querySelector('#telefon').insertAdjacentHTML("afterend", "<label class=\"warning\"> Bitte gib eine gültige Telefonnummer ein.</label>");
                errors = true;
            }
        }
        /*
                if (document.querySelector('#raten') != null) {
                    if (document.querySelector('#raten').value.trim() === '' || document.querySelector('#creditPackage').value < 1 || document.querySelector('#creditPackage').value > 10) {
                        document.querySelector('#raten').insertAdjacentHTML("afterend", "<label class=\"warning\"> Bitte gib eine gültige Rate ein.</label>");
                        errors = true;
                    }
                }
        
                if (document.querySelector('#creditPackage') != null) {
                    if (document.querySelector('#creditPackage').value.trim() === '' || document.querySelector('#creditPackage').value < 1 || document.querySelector('#creditPackage').value > 40) {
                        document.querySelector('#creditPackage').insertAdjacentHTML("afterend", "<label class=\"warning\"> Bitte gib ein gültiges Kredit Paket ein.</label>");
                        errors = true;
                    }
                }
        */
        if (errors) {
            evt.preventDefault();
        }

    });
});