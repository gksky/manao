const form = (document.querySelector('#loginForm')) ? document.querySelector('#loginForm'):  false;

if (form) {
    form.onsubmit = async (e) => {
        e.preventDefault();

        let response = await fetch('/login_handler.php', {
            method: 'POST',
            body: new FormData(form)
        });

        let result = await response.json();

        if (result === 'Success') {
            window.location.href = '/';
        }
        else {
            errLogin.innerText = result.login;
            errPassword.innerText = result.password;
        }
    }
}