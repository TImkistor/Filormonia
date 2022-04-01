<?php
if ($_SERVER['REQUEST_METHOD'] === "GET") { ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="stylesheet" href="/style.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <main>
        <div class="container">
            <h1>Авторизация</h1>
            <form action="/login.php" method="post" name="auth">
                <div id="form-container">
                    <label for="login">Логин</label>
                    <input type="text" required name="login">

                    <label for="password">Пароль</label>
                    <input type="password" required name="password">

                    <button>Авторизоваться</button>
                </div>
            </form>
        </div>
    </main>
    <footer>
        <p id="copyright">© Театр «Хвойный лес»</p>
    </footer>
</body>

</html>


<?php } else {

    require_once 'db.php';

    if (
        !isset($_POST['login']) or 
        !isset($_POST['password'])
    ) {
        error('/login.php', 'Отсутствуют значения');
    }

    $q = "SELECT * FROM users WHERE login = ?";
    $stmt = $db->prepare($q);
    $stmt->execute([$_POST['login']]);

    $user = $stmt->fetch(\PDO::FETCH_ASSOC);

    if (!password_verify($_POST['password'], $user['password'])) {
        error('/login.php', 'Неверный пароль');
    }

    session_start();
    $_SESSION["user"] = $user;

    header('location: /');
}