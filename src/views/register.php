<form id="registerForm">
    <div class="formItem">
        <label>Login:
        <input name="login"><span id="errLogin" class="error"></span>
        </label>
    </div>
    <div class="formItem">
        <label>Password:
        <input name="password" type="password"><span id="errPassword" class="error"></span>
        </label>
    </div>
    <div class="formItem">
        <label>Configm password:
        <input name="confirm_password" type="password"><span id="errConfirm" class="error"></span>
        </label>
    </div>
    <div class="formItem">
        <label>E-mail
        <input name="email" type="email"><span id="errEmail" class="error"></span>
        </label>
    </div>
    <div class="formItem">
        <label>Name:
        <input name="name" type="text"><span id="errName" class="error"></span>
        </label>
    </div>
    <input class="submitButton" type="submit">
</form>

<script src="/src/js/register.js"></script>
</body>
</html>