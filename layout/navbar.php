<nav class="navbar navbar-expand-lg bg-light navbar-light shadow mb-4">
    <div class="container">
        <a class="navbar-brand" href="#">Wings</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="?p=report">Report</a>
            </li>
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-dark" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?php echo $_SESSION['user']; ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-right">
                <li><a class="dropdown-item" href="?p=logout">Logout</a></li>
            </ul>
            </li>
        </ul>
        </div>
    </div>
</nav>