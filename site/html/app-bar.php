<div class="col-md-3 app-bar">
    <ul class="navigation">
        <li><a href="write-view.php"><button>Nouveau message</button></a></li>
        <li><a href="index.php"><button>Boîte de réception</button></a></li>
        <li><a href="modify-password-view.php"><button>Changer son mot de passe</button></a></li>
        <span <?php if($_SESSION['user']->type == 0) echo "style ='display:none;'"; ?>><li><a href="list-user.php"><button>Liste des utilisateurs</button></a></li>
        <li><a href="add-user-view.php"><button>Ajouter un utilisateur</button></a></li></span>
        <li><a href="logout.php"><button>Se déconnecter</button></a></li>
    </ul>
</div>