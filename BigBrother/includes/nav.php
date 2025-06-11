<nav class="navbar navbar-expand-lg bg-white sticky-top">
    <div class="container">
        <a class="logo" href="/BigBrother/index.php">
            <img src="/BigBrother/assets/images/eye.svg" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <!-- Admin-specific nav -->
                        <li class="nav-item"><a class="nav-link" href="/BigBrother/admin/dashboard.php">Admin Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="/BigBrother/admin/news.php">News</a></li>
                        <li class="nav-item"><a class="nav-link" href="/BigBrother/admin/manage_users.php">Users</a></li>
                    <?php else: ?>
                        <!-- Regular user-specific nav -->
                        <li class="nav-item"><a class="nav-link" href="/BigBrother/dashboard.php">My Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="/BigBrother/api/subjects.php">My Notes</a></li>
                        <li class="nav-item"><a class="nav-link" href="/BigBrother/productivity.php">Productivity Area</a></li>
                        <li class="nav-item"><a class="nav-link" href="/BigBrother/insights.php">Insights</a></li>
                        <li class="nav-item"><a class="nav-link" href="/BigBrother/help.php">Help</a></li>
                    <?php endif; ?>
                
                <li class="nav-item ms-3">
                    <a class="btn profile" href="/BigBrother/profile.php">
                        <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Profile'; ?>
                    </a>
                </li>                   
                <li class="nav-item ms-1"><a class="logout btn btn-brand" href="/BigBrother/logout.php">Log out</a></li>
                <?php else: ?>
                    <!-- Guest (not logged in) -->
                    <li class="nav-item"><a class="nav-link" href="/BigBrother/index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#information">Info</a></li>
                    <li class="nav-item"><a class="nav-link" href="#team">Team</a></li>
                    <li class="nav-item"><a class="nav-link" href="help.php">Contact</a></li>
                    <li class="nav-item"><a href="/BigBrother/login.php" class="btn btn-brand ms-lg-3">Login</a></li>
                    <li class="nav-item"><a href="/BigBrother/register.php" class="btn btn-brand ms-lg-3">Register</a></li>
                <?php endif; ?>
                <button id="btn-en" class="btn btn-secondary ms-lg-3">EN</button>
                <button id="btn-de" class="btn btn-secondary ms-lg-1">DE</button>
                <button id="btn-darkmode" class="btn btn-dark ms-lg-1">🌙</button> 
            </ul>
        </div>
    </div>
</nav>