<?php
if ($_SERVER['REQUEST_METHOD'] === "GET") { ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="/style.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <main>
        <div class="container">
            <h1>Регистрация</h1>
            <form action="/registration.php" method="post" name="auth" onsubmit="return checkForm();">
                <div id="form-container">
                    <label for="login">Логин</label>
                    <input type="text" required name="login">

                    <label for="password">Пароль</label>
                    <input type="password" required name="password">
                    
                    <label for="password">Повтор пароля</label>
                    <input type="password" required name="rep_password">

                    <?php if (isset($_GET['error'])) { ?>
                        <span class="error"><?php echo $_GET['error']; ?></span>
                    <?php } ?>
                    <button>Зарегистрироваться</button>
                </div>
            </form>
        </div>
    </main>
    <footer>
        <p id="copyright">© Театр «Хвойный лес»</p>
    </footer>

    <script type="text/javascript">
        function checkForm() {
            noError = true;
            if (checkPasswordsInputs()) {
                $('input[name="rep_password"]').setCustomValidity('');
            } else {
                noError = false;
                $('input[name="rep_password"]').setCustomValidity('Пароли не совпадают');
            }

            return noError;
        }

        function checkPasswordsInputs(){
            return $('input[name="rep_password"]').value === $('input[name="password"]').value;
        }

        function $(selector) {
            return document.querySelector(selector);  
        }
    </script>
</body>
</html>


<?php } else {

    require_once 'db.php';

    if (
        !isset($_POST['login']) or 
        !isset($_POST['password'])
    ) {
        error('/registration.php', 'Отсутствуют значения');
    }

    $q = "INSERT INTO `users` VALUES (NULL,:login,:password)";
    $stmt = $db->prepare($q);

    $user = array(
        ':login' => $_POST['login'],
        ':password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
    );
    $stmt->execute($user);

    $user = array(
        'user_id' => $db->lastInsertId(),
        'login' => $_POST['login'],
        'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
    );

    session_start();
    $_SESSION["user"] = $user;

    header('Location: /');
}