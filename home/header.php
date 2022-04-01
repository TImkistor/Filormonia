<header>
    <nav>
        <a href="/">Главная</a>
        <a href="/poster.php">Афиши</a>
        <a href="/about.php">О нас</a>
    </nav>
    <div class="auth-container">
        <?php session_start();
        if (!isset($_SESSION['user'])) { ?>
            <a href="/login.php">Войти</a>
            <a href="/registration.php">Зарегистрироваться</a>
        <?php } else { ?>
            <span><?php echo $_SESSION['user']['login']; ?></span>
            <a href="/unlogin.php?href=<?php echo explode('?', $_SERVER["REQUEST_URI"])[0]; ?>">Выйти</a>
        <?php } ?>
    </div>
    <script id="SetActiveScript">
        var url = window.location.pathname;
        var navbarChilds = document.querySelectorAll("header>nav>a");
        console.info(navbarChilds);

        for (const navKey of navbarChilds) {
            if (navKey.getAttribute("href") === url)
                navKey.className = "active";
        }

        document.getElementById("SetActiveScript").remove();
    </script>
</header>