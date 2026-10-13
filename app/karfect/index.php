<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require 'includes/db_config.php';

// Check if location is set and valid
$location_set = isset($_SESSION['selected_location']) && isset($_SESSION['pincode']);
$location_pin = $_SESSION['pincode'] ?? null;
$is_kolkata = $location_pin && ($location_pin >= 700001 && $location_pin <= 700088);

if ($location_set && !$is_kolkata) {
    header('Location: ' . BASE_PATH . 'pages/service-unavailable.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karfect - The Partner of Your Needs</title>
    <link href="https://api.fontshare.com/v2/css?f[]=synonym@400&f[]=amulya@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_PATH; ?>assets/css/styles.css?v=<?php echo time(); ?>">
    <link rel="icon" type="image/x-icon" href="<?php echo BASE_PATH; ?>favicon.ico?v=<?php echo time(); ?>">

</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="hero">
        <div class="container">
            <h1 class="heading">Find a Skilled Individual</h1>
            <div class="search-bar-container">
                <input type="text" id="searchInput" class="search-bar" placeholder="Search for ">
                <button class="search-button">
                    <span class="search-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.3-4.3" />
                        </svg>
                    </span>
                </button>
            </div>
            <p class="subheading">5 M+ jobs for you to explore. In the meantime, run to search your next job!</p>
        </div>
    </div>

    <div class="services-list">
        <h1>What are you looking for?</h1>
    </div>

    <div class="parent">
        <div class="div1">
            <img src="<?php echo BASE_PATH; ?>assets/images/pexels-juanpphotoandvideo-1587830.jpg" alt="">
        </div>
        <div class="div2">
            <img src="<?php echo BASE_PATH; ?>assets/images/pexels-rdne-7464722.jpg" alt="">
        </div>
        <div class="div3">
            <img src="<?php echo BASE_PATH; ?>assets/images/pexels-olly-3764568.jpg" alt="">
        </div>
        <div class="div4">
            <img src="<?php echo BASE_PATH; ?>assets/images/pexels-tima-miroshnichenko-6195111.jpg" alt="">
        </div>
        <div class="div7">
            <img src="<?php echo BASE_PATH; ?>assets/images/pexels-karolina-grabowska-4239031.jpg" alt="">
        </div>
        <div class="div8">
            <img src="<?php echo BASE_PATH; ?>assets/images/pexels-liliana-drew-9462307.jpg" alt="">
        </div>
        <div class="div9">
            <img src="<?php echo BASE_PATH; ?>assets/images/pexels-kseniachernaya-5691682.jpg" alt="">
        </div>
        <div class="div10">
            <img src="<?php echo BASE_PATH; ?>assets/images/pexels-ketut-subiyanto-4246109.jpg" alt="">
        </div>
    </div>

    <div class="all_category">
        <h1>All Category</h1>
    </div>

    <div class="grid-container">
        <div class="box">
            <div class="ac">
                <img src="<?php echo BASE_PATH; ?>assets/images/ac_repair.png" alt="">
            </div>
            <p>Ac Repair Service</p>
        </div>
        <div class="box">
            <div class="ac">
                <img src="<?php echo BASE_PATH; ?>assets/images/shifting.png" alt="">
            </div>
            <p>Shifting Service</p>
        </div>
        <div class="box">
            <div class="ac">
                <img src="<?php echo BASE_PATH; ?>assets/images/cleaning.png" alt="">
            </div>
            <p>Clean & Pest Control</p>
        </div>
        <div class="box">
            <div class="ac">
                <img src="<?php echo BASE_PATH; ?>assets/images/beauty.png" alt="">
            </div>
            <p>Beauty & Salon</p>
        </div>
        <div class="box">
            <div class="ac">
                <img src="<?php echo BASE_PATH; ?>assets/images/painting.png" alt="">
            </div>
            <p>Paint & Renovation</p>
        </div>
        <div class="box">
            <div class="ac">
                <img src="<?php echo BASE_PATH; ?>assets/images/event.png" alt="">
            </div>
            <p>Event Management</p>
        </div>
        <div class="box">
            <div class="ac">
                <img src="<?php echo BASE_PATH; ?>assets/images/cooking.png" alt="">
            </div>
            <p>Cook Service</p>
        </div>
    </div>

    <div class="carousel">
        <div class="carousel-inner">
            <div class="carousel-item">
                <a href="https://example.com/page1">
                    <img src="<?php echo BASE_PATH; ?>assets/images/pexels-kseniachernaya-5691682.jpg" alt="Slide 1">
                </a>
            </div>
            <div class="carousel-item">
                <a href="https://example.com/page2">
                    <img src="<?php echo BASE_PATH; ?>assets/images/pexels-ketut-subiyanto-4246109.jpg" alt="Slide 2">
                </a>
            </div>
            <div class="carousel-item">
                <a href="https://example.com/page3">
                    <img src="<?php echo BASE_PATH; ?>assets/images/pexels-liliana-drew-9462307.jpg" alt="Slide 3">
                </a>
            </div>
        </div>
        <button class="carousel-control prev">‹</button>
        <button class="carousel-control next">›</button>
    </div>

    <div class="all_popular_services_container">
        <h1>Frequently booked services</h1>
        <div class="popular_services">
            <div class="first_popular_services">
                <div class="first_popular_services_content">
                    <img src="<?php echo BASE_PATH; ?>assets/images/cheerful-woman-visagiste-smiling-camera (1).jpg" alt="">
                    <div class="mask-overlay">
                        <span class="service-text">Beauty and Salon</span><span class="service-text"><span style="color:#85D95F">✪ </span>4.2</span>
                    </div>
                </div>
            </div>
            <div class="first_popular_services">
                <div class="first_popular_services_content">
                    <img src="<?php echo BASE_PATH; ?>assets/images/haircut.avif" alt="">
                    <div class="mask-overlay">
                        <span class="service-text">Haircut</span><span class="service-text"><span style="color:#85D95F">✪ </span>4.8</span>
                    </div>
                </div>
            </div>
            <div class="first_popular_services">
                <div class="first_popular_services_content">
                    <img src="<?php echo BASE_PATH; ?>assets/images/clean.jpg" alt="">
                    <div class="mask-overlay">
                        <span class="service-text">Cleaning</span><span class="service-text"><span style="color:#85D95F">✪ </span>4.3</span>
                    </div>
                </div>
            </div>
            <div class="first_popular_services">
                <div class="first_popular_services_content">
                    <img src="<?php echo BASE_PATH; ?>assets/images/wallpaint.jpg" alt="">
                    <div class="mask-overlay">
                        <span class="service-text">Wall Painting</span><span class="service-text"><span style="color:#85D95F">✪ </span>4.2</span>
                    </div>
                </div>
            </div>
            <div class="first_popular_services">
                <div class="first_popular_services_content">
                    <img src="<?php echo BASE_PATH; ?>assets/images/cheerful-woman-visagiste-smiling-camera (1).jpg" alt="">
                    <div class="mask-overlay">
                        <span class="service-text">Beauty and Salon</span><span class="service-text"><span style="color:#85D95F">✪ </span>4.5</span>
                    </div>
                </div>
            </div>
            <div class="first_popular_services">
                <div class="first_popular_services_content">
                    <img src="<?php echo BASE_PATH; ?>assets/images/haircut.avif" alt="">
                    <div class="mask-overlay">
                        <span class="service-text">Haircut</span><span class="service-text"><span style="color:#85D95F">✪ </span>4.1</span>
                    </div>
                </div>
            </div>
            <div class="first_popular_services">
                <div class="first_popular_services_content">
                    <img src="<?php echo BASE_PATH; ?>assets/images/clean.jpg" alt="">
                    <div class="mask-overlay">
                        <span class="service-text">Cleaning</span><span class="service-text"><span style="color:#85D95F">✪ </span>4.5</span>
                    </div>
                </div>
            </div>
            <div class="first_popular_services">
                <div class="first_popular_services_content">
                    <img src="<?php echo BASE_PATH; ?>assets/images/wallpaint.jpg" alt="">
                    <div class="mask-overlay">
                        <span class="service-text">Wall Painting</span><span class="service-text"><span style="color:#85D95F">✪ </span>4.2</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h1 class="Salon_for_Women_tittle">Salon for Women</h1>
    <div class="slider-container">
        <button class="arrow left" onclick="scrollSlider('left')">❮</button>
        <a href="<?php echo BASE_PATH; ?>pages/beauty/women/salon.php" class="slider" id="slider">
            <div class="slide">
                <h4>Hair care</h4>
                <img src="<?php echo BASE_PATH; ?>assets/images/hair-care-women.png" alt="">
            </div>
            <div class="slide">
                <h4>Waxing</h4>
                <img src="<?php echo BASE_PATH; ?>assets/images/waxing.png" alt="">
            </div>
            <div class="slide">
                <h4>Cleanup</h4>
                <img src="<?php echo BASE_PATH; ?>assets/images/cleanup.png" alt="">
            </div>
            <div class="slide">
                <h4>Manicure</h4>
                <img src="<?php echo BASE_PATH; ?>assets/images/manicure.png" alt="">
            </div>
            <div class="slide">
                <h4>Facial & Threading</h4>
                <img src="<?php echo BASE_PATH; ?>assets/images/facewaxing & threading.png" alt="">
            </div>
        </a>
        <button class="arrow right" onclick="scrollSlider('right')">❯</button>
    </div>

    <h1 class="Salon_for_Women_tittle">Spa for Women</h1>
    <div class="slider-container">
        <button class="arrow left" onclick="scrollSlider('left')">❮</button>
        <a href="<?php echo BASE_PATH; ?>pages/beauty/women/spa.php" class="slider" id="slider">
            <div class="slide">
                <h4>Stress relief</h4>
                <img src="<?php echo BASE_PATH; ?>assets/images/stress_relief.png" alt="">
            </div>
            <div class="slide">
                <h4>Pain relief</h4>
                <img src="<?php echo BASE_PATH; ?>assets/images/pain relief.png" alt="">
            </div>
            <div class="slide">
                <h4>Natural skincare</h4>
                <img src="<?php echo BASE_PATH; ?>assets/images/skincare.png" alt="">
            </div>
        </a>
        <button class="arrow right" onclick="scrollSlider('right')">❯</button>
    </div>

    <h1 class="Salon_for_Women_tittle">Massage for Men</h1>
    <div class="slider-container">
        <button class="arrow left" onclick="scrollSlider('left')">❮</button>
        <a href="<?php echo BASE_PATH; ?>pages/beauty/men/spa.php" class="slider" id="slider">
            <div class="slide">
                <h4>Stress relief</h4>
                <img src="<?php echo BASE_PATH; ?>assets/images/men stress-relife.png" alt="">
            </div>
            <div class="slide">
                <h4>Pain relief</h4>
                <img src="<?php echo BASE_PATH; ?>assets/images/pain-relief-men.png" alt="">
            </div>
        </a>
        <button class="arrow right" onclick="scrollSlider('right')">❯</button>
    </div>

    <h1 class="Salon_for_Women_tittle">Salon for Kids & Men</h1>
    <div class="slider-container">
        <button class="arrow left" onclick="scrollSlider('left')">❮</button>
        <a href="<?php echo BASE_PATH; ?>pages/beauty/men/salon.php" class="slider" id="slider">
            <div class="slide">
                <h4>Haircut & beard styling</h4>
                <img src="<?php echo BASE_PATH; ?>assets/images/haircut & beard styling.png" alt="">
            </div>
            <div class="slide">
                <h4>Pedicure & manicure</h4>
                <img src="<?php echo BASE_PATH; ?>assets/images/pedicure-men.png" alt="">
            </div>
            <div class="slide">
                <h4>Skincare & cleanup</h4>
                <img src="<?php echo BASE_PATH; ?>assets/images/skincare-men.png" alt="">
            </div>
        </a>
        <button class="arrow right" onclick="scrollSlider('right')">❯</button>
    </div>

    <h1 class="Salon_for_Women_tittle">Cleaning & pest control</h1>
    <div class="slider-container">
        <button class="arrow left" onclick="scrollSlider('left')">❮</button>
        <a href="<?php echo BASE_PATH; ?>pages/home/cleaning/" class="slider" id="slider">
            <div class="slide">
                <h4>Full home cleaning</h4>
                <img src="<?php echo BASE_PATH; ?>assets/images/full_home.png" alt="">
            </div>
            <div class="slide">
                <h4>Bathroom & toilet cleaning</h4>
                <img src="<?php echo BASE_PATH; ?>assets/images/bathroom.png" alt="">
            </div>
            <div class="slide">
                <h4>Kitchen cleaning</h4>
                <img src="<?php echo BASE_PATH; ?>assets/images/kitchen.png" alt="">
            </div>
            <div class="slide">
                <h4>All kinds of pest control</h4>
                <img src="<?php echo BASE_PATH; ?>assets/images/pest-all-kind.png" alt="">
            </div>
        </a>
        <button class="arrow right" onclick="scrollSlider('right')">❯</button>
    </div>

    <h1 class="Salon_for_Women_tittle">All home appliances</h1>
    <div class="slider-container">
        <button class="arrow left" onclick="scrollSlider('left')">❮</button>
        <a href="<?php echo BASE_PATH; ?>pages/home/repairing/" class="slider" id="slider">
            <div class="slide">
                <h4>Ac</h4>
                <img src="<?php echo BASE_PATH; ?>assets/images/ac.png" alt="">
            </div>
            <div class="slide">
                <h4>Refrigerator</h4>
                <img src="<?php echo BASE_PATH; ?>assets/images/fridge.png" alt="">
            </div>
            <div class="slide">
                <h4>Washing machine</h4>
                <img src="<?php echo BASE_PATH; ?>assets/images/washing-machine.png" alt="">
            </div>
            <div class="slide">
                <h4>Microoven</h4>
                <img src="<?php echo BASE_PATH; ?>assets/images/maicro-oven.png" alt="">
            </div>
            <div class="slide">
                <h4>Gyser</h4>
                <img src="<?php echo BASE_PATH; ?>assets/images/gyser.png" alt="">
            </div>
            <div class="slide">
                <h4>Water purifire</h4>
                <img src="<?php echo BASE_PATH; ?>assets/images/water-purifire.png" alt="">
            </div>
            <div class="slide">
                <h4>Television</h4>
                <img src="<?php echo BASE_PATH; ?>assets/images/television.png" alt="">
            </div>
        </a>
        <button class="arrow right" onclick="scrollSlider('right')">❯</button>
    </div>

    <div style="background: #f5f5f5; height: 25px; width: 100vw;"></div>

    <?php include 'partners.php'; ?>
    <?php include 'includes/footer.php'; ?>



    <script src="<?php echo BASE_PATH; ?>assets/js/index.js"></script>

    <!-- chat bot -->
    <script src="<?php echo BASE_PATH; ?>assets/js/chatbot.js"></script>
</body>
</html>
