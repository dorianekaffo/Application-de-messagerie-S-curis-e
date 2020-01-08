<header class="header row">
    <div class="app-name col-md-3 text-center">
        <span>Messagerie</span>
    </div>
    <div class="menu-name col-md-6">
        <span><?php echo $_SESSION["menu"]; ?></span>
    </div>
    <div class="user-info col-md-3 text-center">
        <span>Utilisateur: <?php echo $_SESSION["user"]->pseudo ?></span>
    </div>
</header>