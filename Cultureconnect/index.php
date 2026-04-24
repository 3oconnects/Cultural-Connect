<?php include 'includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CultureConnect | Professional Community Platform</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="assets/css/style.css?v=1.1" rel="stylesheet">
</head>
<body class="landing-body">

<!-- NAVIGATION -->
<nav class="landing-navbar glass fixed-top">
    <div class="container d-flex justify-content-between align-items-center py-2">
        <div class="landing-logo d-flex align-items-center">
            <div class="logo-icon bg-primary text-white p-2 rounded-3 me-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-circle-nodes"></i>
            </div>
            <span class="fw-800 text-dark h4 mb-0">CultureConnect</span>
        </div>

        <div class="nav-links d-none d-lg-flex gap-4">
            <a href="#how-it-works" class="text-dark fw-500 text-decoration-none">How it Works</a>
            <a href="#features" class="text-dark fw-500 text-decoration-none">Features</a>
            <a href="#pricing" class="text-dark fw-500 text-decoration-none">Pricing</a>
        </div>

        <div class="nav-actions d-flex align-items-center gap-3">
            <a href="auth/login.php" class="text-dark fw-600 text-decoration-none">Login</a>
            <a href="auth/signup.php" class="btn btn-landing-pink px-4">Get Started</a>
        </div>
    </div>
</nav>

<!-- HERO SECTION -->
<section class="hero-section position-relative overflow-hidden" style="padding-top: 200px; padding-bottom: 140px; background: radial-gradient(circle at top right, #fdf2f8, #f8fafc), url('https://www.transparenttextures.com/patterns/cubes.png');">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 mb-5 mb-lg-0">
                <div class="hero-content animate-up">
                    <div class="badge bg-indigo-soft text-indigo mb-4 px-3 py-2 rounded-pill fw-bold">
                        <i class="fas fa-sparkles me-2"></i> Elevate Your Community Experience
                    </div>
                    <h1 class="display-2 fw-800 mb-4 lh-1 text-dark">
                        Discover & Support <br><span class="gradient-text">Local Culture</span>.
                    </h1>
                    <p class="lead text-muted mb-5 pe-lg-5 h5 lh-lg">
                        CultureConnect provides the ultimate infrastructure for local companies to list products and for residents to shape their community through active discovery and voting.
                    </p>
                    
                    <div class="hero-search-wrapper d-flex align-items-center animate-up" style="animation-delay: 0.1s;">
                        <i class="fas fa-search text-muted ms-3"></i>
                        <input type="text" class="hero-search-input" placeholder="Search for art, music, or local services...">
                        <button class="btn btn-search me-1 px-4">Search</button>
                    </div>

                    <div class="mt-4 small text-muted">
                        Popular: <span class="badge bg-light text-dark mx-1">Art Studios</span> <span class="badge bg-light text-dark mx-1">Music Classes</span> <span class="badge bg-light text-dark mx-1">Handicrafts</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="hero-visual-wrapper position-relative animate-up" style="animation-delay: 0.2s;">
                    <div class="hero-main-img shadow-2xl rounded-5 overflow-hidden border border-white border-5">
                        <img src="assets/img/hero-culture.png" class="img-fluid" alt="CultureConnect Hero">
                    </div>
                    <div class="stat-bubble glass p-3 rounded-4 shadow-lg position-absolute top-0 end-0 m-4 animate-bounce">
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon bg-success text-white rounded-circle p-2"><i class="fas fa-chart-line"></i></div>
                            <div>
                                <div class="fw-bold small">+24% Growth</div>
                                <div class="text-muted smaller">In local listing participation</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FEATURES GRID -->
<section id="features" class="py-8 bg-white">
    <div class="container">
        <div class="text-center mb-5 pb-4">
            <h2 class="fw-800 h1">Advanced <span class="gradient-text">Features</span></h2>
            <p class="text-muted">Professional tools built for both residents and cultural entities.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon bg-primary-soft text-primary"><i class="fas fa-layer-group"></i></div>
                    <h4>Centralized Registry</h4>
                    <p>A unified database for all cultural products and services across multiple local areas.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon bg-secondary-soft text-secondary"><i class="fas fa-check-to-slot"></i></div>
                    <h4>Transparent Voting</h4>
                    <p>Decentralized community feedback system allowing residents to influence local trends.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon bg-success-soft text-success"><i class="fas fa-chart-pie"></i></div>
                    <h4>Detailed Analytics</h4>
                    <p>Real-time reports for administrators to track participation and cultural growth.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PRICING SECTION -->
<section id="pricing" class="py-8 bg-light">
    <div class="container">
        <div class="text-center mb-5 pb-4">
            <h2 class="fw-800 h1">Simple <span class="gradient-text">Pricing</span></h2>
            <p class="text-muted">Choose the plan that best fits your community role.</p>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="pricing-card bg-white p-5 rounded-5 border h-100 hover-lift">
                    <h5 class="fw-bold mb-4">Resident</h5>
                    <div class="display-4 fw-800 mb-4">$0 <span class="h6 text-muted">/forever</span></div>
                    <ul class="list-unstyled mb-5">
                        <li class="mb-3"><i class="fas fa-check text-success me-2"></i> Unlimited product discovery</li>
                        <li class="mb-3"><i class="fas fa-check text-success me-2"></i> Community voting rights</li>
                        <li class="mb-3"><i class="fas fa-check text-success me-2"></i> Personalized area feed</li>
                    </ul>
                    <a href="auth/signup.php" class="btn btn-outline-primary w-100 py-3 fw-bold rounded-3">Join as Resident</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="pricing-card bg-white p-5 rounded-5 border-4 border-primary h-100 hover-lift position-relative shadow-lg">
                    <span class="badge bg-primary position-absolute top-0 start-50 translate-middle px-3 py-2 rounded-pill">MOST POPULAR</span>
                    <h5 class="fw-bold mb-4">Company</h5>
                    <div class="display-4 fw-800 mb-4">$19 <span class="h6 text-muted">/month</span></div>
                    <ul class="list-unstyled mb-5">
                        <li class="mb-3"><i class="fas fa-check text-success me-2"></i> List unlimited products</li>
                        <li class="mb-3"><i class="fas fa-check text-success me-2"></i> Detailed vote analytics</li>
                        <li class="mb-3"><i class="fas fa-check text-success me-2"></i> Verified company badge</li>
                        <li class="mb-3"><i class="fas fa-check text-success me-2"></i> Priority search placement</li>
                    </ul>
                    <a href="auth/signup.php" class="btn btn-primary w-100 py-3 fw-bold rounded-3 shadow">List Your Business</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA SECTION -->
<section class="py-8 text-center bg-dark text-white rounded-5 mx-3 mb-5 overflow-hidden">
    <div class="container py-4">
        <h2 class="display-4 fw-800 mb-4">Start Connecting <span class="text-secondary">Today</span></h2>
        <p class="lead text-white-50 mb-5">Join the platform that is redefining local cultural ecosystems.</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="auth/signup.php" class="btn btn-landing-pink btn-lg px-5 py-3">Get Started for Free</a>
            <a href="auth/login.php" class="btn btn-outline-light btn-lg px-5 py-3 rounded-3">Member Login</a>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="py-8 bg-white border-top">
    <div class="container text-center">
        <div class="landing-logo d-flex align-items-center justify-content-center mb-4">
            <div class="logo-icon bg-primary text-white p-2 rounded-3 me-2">
                <i class="fas fa-circle-nodes"></i>
            </div>
            <span class="fw-800 text-dark h4 mb-0">CultureConnect</span>
        </div>
        <p class="text-muted small mb-4">&copy; 2026 CultureConnect Platform. Bridging Local Talent & Community Support.</p>
        <div class="d-flex justify-content-center gap-4">
            <a href="#" class="text-muted text-decoration-none">Privacy</a>
            <a href="#" class="text-muted text-decoration-none">Terms</a>
            <a href="#" class="text-muted text-decoration-none">Contact</a>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>