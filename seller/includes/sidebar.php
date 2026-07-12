<aside class="sidebar">

    <div class="logo">

        <img
            src="../assets/images/hero_logo.png"
            alt="Brew Haven"
            class="sidebar-logo">

        <h3>Brew Haven</h3>

        <small>Administrator</small>

    </div>

    <ul>

        <li class="<?= ($currentPage=="dashboard") ? "active" : ""; ?>">

            <a href="../seller/dashboard.php">

                <i class="bi bi-speedometer2"></i>

                Dashboard

            </a>

        </li>

        <li class="<?= ($currentPage=="products") ? "active" : ""; ?>">

            <a href="../seller/products.php">

                <i class="bi bi-cup-hot"></i>

                Products

            </a>

        </li>

        <li class="<?= ($currentPage=="categories") ? "active" : ""; ?>">

            <a href="../seller/categories.php">

                <i class="bi bi-grid"></i>

                Categories

            </a>

        </li>

        <li class="<?= ($currentPage=="customers") ? "active" : ""; ?>">

            <a href="../seller/users.php">

                <i class="bi bi-people"></i>

                Customers

            </a>

        </li>

        <li class="<?= ($currentPage=="orders") ? "active" : ""; ?>">

            <a href="../seller/orders.php">

                <i class="bi bi-cart"></i>

                Orders

            </a>

        </li>

        <li class="<?= ($currentPage=="reports") ? "active" : ""; ?>">

            <a href="../seller/reports.php">

                <i class="bi bi-bar-chart"></i>

                Reports

            </a>

        </li>

        <li class="<?= ($currentPage=="audit") ? "active" : ""; ?>">

            <a href="../seller/audit_logs.php">

                <i class="bi bi-clock-history"></i>

                Audit Logs

            </a>

        </li>

        <li>

            <a href="../buyer/logout.php">

                <i class="bi bi-box-arrow-right"></i>

                Logout

            </a>

        </li>

    </ul>

</aside>