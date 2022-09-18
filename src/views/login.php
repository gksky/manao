<?php if (empty($_SESSION['auth'])): ?>
  <form id="loginForm" class="form">
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
    <input class="submitButton" type="submit">
  </form>
<?php endif; ?>

  <script src="/src/js/login.js"></script>
</body>
</html>