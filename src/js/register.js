const form = (document.querySelector('#registerForm')) ? document.querySelector('#registerForm'):  false;

if (form) {
    form.onsubmit = async (e) => {
        e.preventDefault();
    
        let response = await fetch('/register_handler.php', {
            method: 'POST',
            body: new FormData(form)
        });
    
        let result = await response.json();
    
        if (result === 'Success') {
            window.location.href = '/login.php';
        }
        else {
            errLogin.innerText = result.login;
            errPassword.innerText = result.password;
            errConfirm.innerText = result.confirm_password;
            errEmail.innerText = result.email;
            errName.innerText = result.name;
        }
    }
};