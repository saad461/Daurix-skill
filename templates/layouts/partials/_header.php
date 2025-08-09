<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom sticky-top">
    <div class="container-fluid">

        <button class="btn btn-primary" id="sidebarToggle"><i class="bi bi-list"></i></button>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                <!-- Dark Mode Toggle -->
                <li class="nav-item me-3">
                    <div class="form-check form-switch d-flex align-items-center h-100">
                        <input class="form-check-input" type="checkbox" role="switch" id="themeSwitch">
                        <label class="form-check-label ms-2" for="themeSwitch"><i class="bi bi-moon-stars-fill"></i></label>
                    </div>
                </li>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- Logged-in User Controls -->
                    <li class="nav-item"><a class="nav-link" href="/notifications"><i class="bi bi-bell-fill"></i></a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bi bi-person-circle me-1"></i>
                            <?= htmlspecialchars($_SESSION['user_name']) ?>
                            <span class="badge rounded-pill bg-warning text-dark ms-2">
                                <i class="bi bi-star-fill"></i> <?= $_SESSION['user_points'] ?? 0 ?>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/dashboard">Dashboard</a>
                            <a class="dropdown-item" href="/profile">Profile</a>
                            <a class="dropdown-item" href="/points-history">Points History</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/logout">Logout</a>
                        </div>
                    </li>
                <?php else: ?>
                    <!-- Guest Controls -->
                    <li class="nav-item">
                        <a href="/login" class="btn btn-outline-primary me-2">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="/register" class="btn btn-primary">Sign Up</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
