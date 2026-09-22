<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require '../../includes/db_config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo BASE_PATH;  ?>assets/css/women.css?v=<?php echo time();?>">
    <link rel="stylesheet" href="<?php echo BASE_PATH;  ?>assets/css/styles.css">
    <title>Home Services - karfect</title>
    <link rel="icon" type="image/x-icon" href="<?php echo BASE_PATH; ?>favicon.ico?v=<?php echo time(); ?>">
</head>
<body>
    <?php include '../../includes/header.php'; ?>

    <style>
        .collage {
            background-color: #ffffff;
            width: 30vw;
            height: 42vh;
            display: flex;
            gap: 8px;
        }
        .first-column {
            width: 50%;
           
        }
        .first-img {
            height: 60%;
        }
        .second-img {
            height: 40%;
        }
        .third-img {
            height: 40%;
        }
        .fourth-img {
            height: 60%;
        }


        .first-img img {
            object-fit: cover;
            height: 100%;
            width: 100%;
            border-bottom: 8px solid white;
            border-radius: 8px 0px 0px 0px;
        }

        .second-img img {
            object-fit: cover;
            height: 100%;
            width: 100%;
            border-radius: 0px 0px 0px 8px;
        }

        .third-img img  {
            object-fit: cover;
            height: 100%;
            width: 100%;
            border-radius: 0px 8px 0px 0px;
        }

        .fourth-img img {
            object-fit: cover;
            height: 100%;
            width: 100%;
            border-top: 8px solid white;
            border-radius: 0px 0px 8px 0px;
        }

        

        .second-column {
            width: 50%;
        }

        @media (max-width: 768px) {
            .collage {
                width: 100vw;
                height: 60vh;
                padding: 0px 10px;
            }
        }

        @media (max-width: 458px) {
            .collage {
                height: 45vh;
            }
        }
       
    </style>

    <div class="all_women_services_container" style="padding: 0%;" >
        <div class="main-services-container" style="padding: 0%;">
            <div class="carousel-promo-container">
                <div class="women-carousel" style="border-radius: 0px 0px 0px 0px">
                    <div class="women-carousel-inner">
                        <div class="women-carousel-item">
                            <img src="<?php echo BASE_PATH; ?>assets/images/sofa_cleaning.avif" alt="Slide 1">
                        </div>
                        <div class="women-carousel-item">
                            <img src="<?php echo BASE_PATH; ?>assets/images/whole_bathroom_cleaning.avif" alt="Slide 2">
                        </div>
                        <div class="women-carousel-item">
                            <img src="<?php echo BASE_PATH; ?>assets/images/pest-all-kind.png" alt="Slide 3">
                        </div>
                    </div>
                    <div class="progress-container">
                        <div class="progress-bar"><div class="progress active"></div></div>
                        <div class="progress-bar"><div class="progress"></div></div>
                        <div class="progress-bar"><div class="progress"></div></div>
                    </div>
                </div>
                <div class="promo-section2" style="border-radius: 0px 0px 18px 18px;"></div>
            </div>

            <!-- collage -->
            <div style="margin-top: 20px; text-align: center; " class="collage_parent">
                <h2 style="font-size: 24px; font-weight: bold; color: #333; margin-bottom: 20px;">What are you looking for?</h2>
                <div class="collage">
                    <div class="first-column">
                        <div class="first-img"><img src="<?php echo BASE_PATH; ?>assets/images/ac_repair1.avif" alt=""></div>
                        <div class="second-img"><img src="<?php echo BASE_PATH; ?>assets/images/sofa_cleaning.avif" alt=""></div>
                    </div>
                    <div class="second-column">
                        <div class="third-img"><img src="<?php echo BASE_PATH; ?>assets/images/refrigetor_geyser_washing_machine.avif" alt=""></div>
                        <div class="fourth-img"><img src="<?php echo BASE_PATH; ?>assets/images/tv_computer.avif" alt=""></div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- most book services - home -->

    <div class="all_popular_services_container">
        <h1>Frequently booked services</h1>
        <div class="popular_services">
            <div class="first_popular_services">
                <div class="first_popular_services_content">
                    <img src="<?php echo BASE_PATH; ?>assets/images/ac_repair1.avif" alt="">
                    <div class="mask-overlay">
                        <span class="service-text">Ac Repairing</span><span class="service-text"><span style="color:#85D95F">✪ </span>4.2</span>
                    </div>
                </div>
            </div>
            <div class="first_popular_services">
                <div class="first_popular_services_content">
                    <img src="<?php echo BASE_PATH; ?>assets/images/refrigetor_geyser_washing_machine.avif" alt="">
                    <div class="mask-overlay">
                        <span class="service-text">Refrigetor Repairing</span><span class="service-text"><span style="color:#85D95F">✪ </span>4.8</span>
                    </div>
                </div>
            </div>
            <div class="first_popular_services">
                <div class="first_popular_services_content">
                    <img src="<?php echo BASE_PATH; ?>assets/images/pest_cleaning2.avif" alt="">
                    <div class="mask-overlay">
                        <span class="service-text">Pest Cleaning</span><span class="service-text"><span style="color:#85D95F">✪ </span>4.3</span>
                    </div>
                </div>
            </div>
            <div class="first_popular_services">
                <div class="first_popular_services_content">
                    <img src="<?php echo BASE_PATH; ?>assets/images/home_cleaning2.avif" alt="">
                    <div class="mask-overlay">
                        <span class="service-text">Full Home Clean</span><span class="service-text"><span style="color:#85D95F">✪ </span>4.2</span>
                    </div>
                </div>
            </div>
            <div class="first_popular_services">
                <div class="first_popular_services_content">
                    <img src="<?php echo BASE_PATH; ?>assets/images/whole_bathroom_cleaning.avif" alt="">
                    <div class="mask-overlay">
                        <span class="service-text">Bathroom Cleaning</span><span class="service-text"><span style="color:#85D95F">✪ </span>4.5</span>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <!-- home appliances -->

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

    <!-- pest control -->

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

    <?php include '../../includes/footer.php'; ?>

    <script>
        const carouselInner = document.querySelector('.women-carousel-inner');
        const items = document.querySelectorAll('.women-carousel-item');
        const progressBars = document.querySelectorAll('.progress');
        const totalItems = items.length;
        let currentIndex = 0;

        function updateProgressBars() {
            progressBars.forEach(progress => progress.classList.remove('active'));
            progressBars.forEach(progress => progress.style.width = '0');
            progressBars[currentIndex].classList.add('active');
        }

        function slideCarousel() {
            currentIndex = (currentIndex + 1) % totalItems;
            carouselInner.style.transform = `translateX(-${currentIndex * (100 / totalItems)}%)`;
            updateProgressBars();
        }

        updateProgressBars();
        setInterval(slideCarousel, 5000);

        // Overlay Functionality
        const overlay = document.getElementById('serviceOverlay');
        const closeOverlay = document.getElementById('closeOverlay');
        const viewDetailsButtons = document.querySelectorAll('.view-details-button');

        function openOverlay() {
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden'; // Prevent scrolling
        }

        function closeOverlayFunc() {
            overlay.classList.remove('active');
            document.body.style.overflow = 'auto'; // Restore scrolling
        }

        viewDetailsButtons.forEach(button => {
            button.addEventListener('click', () => {
                // You can fetch service details dynamically here using button.dataset.serviceId
                openOverlay();
            });
        });

        closeOverlay.addEventListener('click', closeOverlayFunc);

        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                closeOverlayFunc();
            }
        });

        // Optional: Close on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && overlay.classList.contains('active')) {
                closeOverlayFunc();
            }
        });
    </script>
</body>
</html>