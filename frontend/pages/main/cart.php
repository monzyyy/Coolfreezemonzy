<?php


// Start here. Change 
require_once dirname(__DIR__, 3) . '/backend/bootstrap.php';

// Log in name ng customer: example - markesg
$userName = $_SESSION['username'] ?? 'Customer';

$currentPage = 'home';

// Sidebar menu 
$menu = [
    [
        'title' => 'Services',
        'items' => [
            ['label' => 'Services', 'icon' => 'fa-screwdriver-wrench', 'link' => 'servicesmain.php'],
        ]
    ],
    [
        'title' => 'Cart',
        'items' => [
            ['label' => 'Service Cart', 'icon' => 'fa-cart-shopping', 'link' => 'cart.php'],
        ]
    ],
    [
        'title' => 'Service Requests',
        'items' => [
            ['label' => 'My Requests', 'icon' => 'fa-clipboard-list', 'link' => 'requests.php'],
        ]
    ],
    [
        'title' => 'System',
        'items' => [
            ['label' => 'Profile', 'icon' => 'fa-user', 'link' => 'profile.php'],
            ['label' => "Helps and FAQ's", 'icon' => 'fa-circle-question', 'link' => 'faqs.php'],
            ['label' => 'Settings', 'icon' => 'fa-gear', 'link' => 'settings.php'],
        ]
    ],
];
// change end

// Services 
$services = [
    ['id' => 1, 'title' => 'AC Cleaning', 'description' => 'Keep your AC clean and efficient', 'icon' => 'fa-fan'],
    ['id' => 2, 'title' => 'AC Repair', 'description' => 'Fix your AC problems quickly', 'icon' => 'fa-screwdriver-wrench'],
    ['id' => 3, 'title' => 'AC Maintenance', 'description' => 'Prevents Problems', 'icon' => 'fa-gear'],
    ['id' => 4, 'title' => 'AC Installation', 'description' => 'Installation for your new AC', 'icon' => 'fa-wind'],
    ['id' => 5, 'title' => 'Parts Replacements', 'description' => 'Replace Damaged Parts', 'icon' => 'fa-toolbox'],
];

// Temporary request data
// Status values: Pending | Confirmed | On going | Cancelled
$recentRequests = [
    ['id' => 125, 'service' => 'Parts Replacement', 'date' => 'September 26, 2025', 'status' => 'Pending'],
    ['id' => 124, 'service' => 'AC Cleaning', 'date' => 'September 26, 2025', 'status' => 'Confirmed'],
    ['id' => 123, 'service' => 'AC Cleaning', 'date' => 'Sep 15, 2025', 'status' => 'On going'],
    ['id' => 122, 'service' => 'AC Cleaning', 'date' => 'Sep 15, 2025', 'status' => 'Cancelled'],
];

$totalRequests = count($recentRequests); 

// AC Care Tips 
$careTips = [
    ['icon' => 'fa-filter', 'title' => 'Clean Filters Monthly', 'text' => 'Regular cleaning can improve efficiency by up to 15% and extend your unit\'s lifespan.'],
    ['icon' => 'fa-temperature-half', 'title' => 'Set Optimal Temperature', 'text' => '24-26°C is the ideal range — comfortable and energy-efficient for Philippine weather.'],
    ['icon' => 'fa-calendar-check', 'title' => 'Schedule Annual Check-ups', 'text' => 'A yearly professional inspection catches small issues before they become expensive repairs.'],
];


// change
function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
// end


// Turn a status label into a CSS class suffix, e.g. "On going" -> "ongoing"
function statusClass($status)
{
    return strtolower(str_replace(' ', '', $status));
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoolFreeze | Homepage</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>frontend/assets/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="layout">

<!-- Change start -->
    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">

        <img class="imglogo"
                        src="<?= BASE_URL ?>frontend/assets/img/coolfreeze_horizontal_logo.svg"
                        alt="Bright living room with a grey sofa"
                        class="card-img"
                    >

        <nav class="menu">

            <!-- DASHBOARD -->
            <p class="menu-title">Dashboard</p>

            <a href="index.php" class="menu-link">
                <i class="fa-solid fa-house"></i>
                Home
            </a>

            <!-- MENU SECTIONS -->
            <?php foreach ($menu as $section): ?>

                <p class="menu-title"><?= e($section['title']) ?></p>

                <?php foreach ($section['items'] as $item): ?>

                    <a href="<?= e($item['link']) ?>" class="menu-link <?= $item['link'] === 'cart.php' ? 'active' : '' ?>">
                        <i class="fa-solid <?= e($item['icon']) ?>"></i>
                        <?= e($item['label']) ?>
                    </a>

                <?php endforeach; ?>

            <?php endforeach; ?>

        </nav>

        <!-- LOGOUT -->
        <form action="<?= BASE_URL ?>backend/api/logout.php" method="POST" class="logout-form">
            <button type="submit" class="logout">
                <i class="fa-solid fa-right-from-bracket"></i>
                Log out
            </button>
        </form>

    </aside>
    <!-- change end -->

    <!-- MOBILE OVERLAY -->
    <div class="overlay" id="overlay"></div>

    <!-- MAIN CONTENT -->
    <div class="main">

        <!-- TOPBAR -->
        <header class="topbar">

            <button type="button" class="menu-button" id="menuButton" aria-label="Open menu">
                <i class="fa-solid fa-bars"></i>
            </button>

            <!-- SEARCH -->
            <form class="search" action="search.php" method="GET">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="search" name="q" placeholder="Search">
            </form>

            <!-- TOP ACTIONS -->
            <div class="top-actions">

                <a href="notifications.php" class="icon-link" aria-label="Notifications">
                  <i class="fa-solid fa-bell"></i>
                </a>

                <a href="cart.php" class="icon-link" aria-label="Cart">
                    <i class="fa-solid fa-cart-shopping"></i>
                </a>

                <a href="profile.php" class="profile-link">
                    <i class="fa-solid fa-user"></i>
                    <span><?= e($userName) ?></span>
                </a>

            </div>

        </header>

        <!-- PAGE CONTENT -->
        <main class="content">

            <!-- WELCOME -->
            <div class="page-header">

                <nav
                    class="breadcrumb"
                    aria-label="Breadcrumb"
                >

                    <a href="index.php">
                        Home
                    </a>

                    <i class="fa-solid fa-chevron-right"></i>

                    <span>
                        Service Cart
                    </span>


                </nav>


                <h1 class="page-title">

                    My
                    <span>Service Cart</span>

                </h1>


                <p class="page-subtitle">

                    Review your selected services before proceding to request

                </p>

            </div>

            <!-- SERVICES (full width row) -->
            <section class="panel services-panel">

                <div class="panel-head">

                    <h2 class="panel-title">
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                        Services
                    </h2>

                    <a href="<?= BASE_URL ?>frontend/pages/main/servicesmain.php" class="view-all">
                        View all
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>

                </div>

                <div class="service-grid">

                    <?php foreach ($services as $service): ?>

                        <a href="service.php?id=<?= (int) $service['id'] ?>" class="service-card">

                            <span class="service-icon">
                                <i class="fa-solid <?= e($service['icon']) ?>"></i>
                            </span>

                            <h3><?= e($service['title']) ?></h3>

                            <p><?= e($service['description']) ?></p>

                        </a>

                    <?php endforeach; ?>

                </div>

            </section>

            <!-- BOTTOM ROW: recent requests + AC care tips, side by side -->
            <div class="bottom-grid">

                <!-- RECENT REQUESTS -->
                <section class="panel requests-panel">

                    <div class="panel-head">

                        <h2 class="panel-title">My Recent Request</h2>

                        <a href="requests.php" class="view-all">
                            View all
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>

                    </div>

                    <div class="table">

                        <!-- TABLE HEADER -->
                        <div class="table-row table-head">
                            <span>Request ID</span>
                            <span>Service</span>
                            <span>Date</span>
                            <span>Status</span>
                        </div>

                        <!-- REQUESTS -->
                        <?php if (empty($recentRequests)): ?>

                            <div class="empty-request">
                                <i class="fa-regular fa-folder-open"></i>
                                <p>You don't have any service requests yet.</p>
                                <a href="service.php">Browse Services</a>
                            </div>

                        <?php else: ?>

                            <?php foreach ($recentRequests as $request): ?>

                                <div class="table-row" data-request-id="<?= (int) $request['id'] ?>">

                                    <span class="request-id">
                                        SR-<?= str_pad((string) $request['id'], 6, '0', STR_PAD_LEFT) ?>
                                    </span>

                                    <span><?= e($request['service']) ?></span>

                                    <span class="date"><?= e($request['date']) ?></span>

                                    <span>
                                        <span class="badge <?= e(statusClass($request['status'])) ?>">
                                            <?= e($request['status']) ?>
                                        </span>
                                    </span>

                                </div>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    </div>

                    <div class="table-footer">

                        <span class="count">
                            Show <?= (int) $totalRequests ?> of <?= (int) $totalRequests ?> requests
                        </span>

                        <a href="requests.php?new=1" class="new-request">
                            + New Request
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>

                    </div>

                </section>

                <!-- AC CARE TIPS -->
                <aside class="tips-panel">

                    <h2 class="tips-title">AC Care Tips</h2>

                    <?php foreach ($careTips as $tip): ?>

                        <div class="tip">

                            <span class="tip-icon">
                                <i class="fa-solid <?= e($tip['icon']) ?>"></i>
                            </span>

                            <div>
                                <h4><?= e($tip['title']) ?></h4>
                                <p><?= e($tip['text']) ?></p>
                            </div>

                        </div>

                    <?php endforeach; ?>

                </aside>

            </div>

        </main>

    </div>

</div>

<script src="<?= BASE_URL ?>frontend/assets/js/custom.js"></script>

</body>

</html>