<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require '../../../includes/db_config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Women Services - Karfect</title>
    <link rel="stylesheet" href="<?php echo BASE_PATH; ?>assets/css/women.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo BASE_PATH; ?>assets/css/cart.css?v=<?php echo time(); ?>">
    <link rel="icon" type="image/x-icon" href="<?php echo BASE_PATH; ?>favicon.ico?v=<?php echo time(); ?>">
</head>
<body>
    <?php include '../../../includes/header.php'; ?>

    <div class="all_women_services_container">
        <div class="main-services-container">
            <div class="carousel-promo-container">
                <div class="women-carousel">
                    <div class="women-carousel-inner">
                        <div class="women-carousel-item">
                            <img src="<?php echo BASE_PATH; ?>assets/images/cheerful-woman-visagiste-smiling-camera (1).jpg" alt="Slide 1">
                        </div>
                        <div class="women-carousel-item">
                            <img src="<?php echo BASE_PATH; ?>assets/images/pain-relief-men.png" alt="Slide 2">
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
                <div class="promo-section2"></div>
            </div>

            <div class="service-selector">
                <p class="selector-title">Select a service</p>
                <ul class="service-list">
                    <li class="service-item">
                        <div class="service-icon">
                            <img src="<?php echo BASE_PATH; ?>assets/images/53.png" alt="Massage" class="icon-image" />
                        </div>
                        <span class="service-label">Pain relief</span>
                    </li>
                    <li class="service-item">
                        <div class="service-icon">
                            <img src="<?php echo BASE_PATH; ?>assets/images/55.png" alt="Facial" class="icon-image" />
                        </div>
                        <span class="service-label">Stress relief</span>
                    </li>
                    <li class="service-item">
                        <div class="service-icon">
                            <img src="<?php echo BASE_PATH; ?>assets/images/59.png" alt="Manicure" class="icon-image" />
                        </div>
                        <span class="service-label">Add-on</span>
                    </li>
                    <li class="service-item">
                        <div class="service-icon">
                            <img src="<?php echo BASE_PATH; ?>assets/images/47.png" alt="Hair cut" class="icon-image" />
                        </div>
                        <span class="service-label">Skin-care & scrubs</span>
                    </li>
                    
                </ul>
            </div>
        </div>
    </div>

    <div class="women-all_service-add-card">
        <h2>Pain relief</h2>
        <div class="all_service-card">
            <?php
            $stmt = $conn->prepare("SELECT * FROM services WHERE category = 'women_pain_relief'");

            $stmt->execute();
            $services = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($services as $service):
                // Handle image path: Use full path from DB, fallback to assets/images if legacy
                $image_path = strpos($service['image'], 'uploads/') === 0 ? BASE_PATH . $service['image'] : BASE_PATH . 'assets/images/' . $service['image'];
            ?>
                <div class="service-card" id="card-<?php echo $service['id']; ?>" aria-label="<?php echo htmlspecialchars($service['title']); ?>">
                    <div class="service-image">
                        <img src="<?php echo htmlspecialchars($image_path); ?>" alt="<?php echo htmlspecialchars($service['title']); ?>" />
                    </div>
                    <div class="service-details">
                        <div>
                            <h2 class="service-title"><?php echo htmlspecialchars($service['title']); ?></h2>
                            <div class="service-rating">
                                <svg class="rating-icon" viewBox="0 0 20 20" fill="#572AC8" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M18.333 10a8.333 8.333 0 11-16.667 0 8.333 8.333 0 0116.667 0zm-7.894-4.694A.476.476 0 009.999 5a.476.476 0 00-.438.306L8.414 8.191l-2.977.25a.48.48 0 00-.414.342.513.513 0 00.143.532l2.268 2.033-.693 3.039a.51.51 0 00.183.518.458.458 0 00.528.022L10 13.298l2.548 1.629a.458.458 0 00.527-.022.51.51 0 00.184-.518l-.693-3.04 2.268-2.032a.513.513 0 00.143-.532.48.48 0 00-.415-.342l-2.976-.25-1.147-2.885z"/>
                                </svg>
                                <span class="rating-text"><?php echo number_format($service['rating'], 2); ?> (<?php echo number_format($service['reviews']); ?> reviews)</span>
                            </div>
                            <div class="service-price-duration">
                                <div class="service-price-container">
                                    <span class="service-original-price">₹<?php echo number_format($service['original_price'], 2); ?></span>
                                    <span class="service-discounted-price">₹<?php echo number_format($service['discounted_price'], 2); ?></span>
                                </div>
                                <span class="service-duration">
                                    <svg class="duration-icon" viewBox="0 0 24 24" fill="#545454" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <?php echo htmlspecialchars($service['duration']); ?>
                                </span>
                            </div>
                            <div class="service-description">
                                <?php
                                $desc_items = explode('. ', $service['description']);
                                foreach ($desc_items as $item):
                                    if (trim($item)):
                                ?>
                                    <div class="description-item">
                                        <svg class="description-icon" viewBox="0 0 24 24" fill="#545454" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <?php echo htmlspecialchars(trim($item)); ?>
                                    </div>
                                <?php endif; endforeach; ?>
                            </div>
                        </div>
                        <div class="service-actions">
                            <button class="add-button" data-service-id="<?php echo $service['id']; ?>" aria-label="Add">Add</button>
                            <div class="quantity-control" style="display: none;">
                                <button class="quantity-button decrease" aria-label="Decrease quantity">
                                    <svg viewBox="0 0 24 24" fill="#6e42e5" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M20.25 13H3.75v-2h16.5v2z"/>
                                    </svg>
                                </button>
                                <span class="quantity-display">1</span>
                                <button class="quantity-button increase" aria-label="Increase quantity">
                                    <svg viewBox="0 0 24 24" fill="#6e42e5" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11 13v7.25h2V13h7.25v-2H13V3.75h-2V11H3.75v2H11z"/>
                                    </svg>
                                </button>
                            </div>
                            <button class="view-details-button" data-service-id="<?php echo $service['id']; ?>" aria-label="View Details">View details</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <h2>Stress relief</h2>
        <div class="all_service-card">
            <?php
            $stmt = $conn->prepare("SELECT * FROM services WHERE category = 'women_stress_relief'");

            $stmt->execute();
            $services = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($services as $service):
                // Handle image path: Use full path from DB, fallback to assets/images if legacy
                $image_path = strpos($service['image'], 'uploads/') === 0 ? BASE_PATH . $service['image'] : BASE_PATH . 'assets/images/' . $service['image'];
            ?>
                <div class="service-card" id="card-<?php echo $service['id']; ?>" aria-label="<?php echo htmlspecialchars($service['title']); ?>">
                    <div class="service-image">
                        <img src="<?php echo htmlspecialchars($image_path); ?>" alt="<?php echo htmlspecialchars($service['title']); ?>" />
                    </div>
                    <div class="service-details">
                        <div>
                            <h2 class="service-title"><?php echo htmlspecialchars($service['title']); ?></h2>
                            <div class="service-rating">
                                <svg class="rating-icon" viewBox="0 0 20 20" fill="#572AC8" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M18.333 10a8.333 8.333 0 11-16.667 0 8.333 8.333 0 0116.667 0zm-7.894-4.694A.476.476 0 009.999 5a.476.476 0 00-.438.306L8.414 8.191l-2.977.25a.48.48 0 00-.414.342.513.513 0 00.143.532l2.268 2.033-.693 3.039a.51.51 0 00.183.518.458.458 0 00.528.022L10 13.298l2.548 1.629a.458.458 0 00.527-.022.51.51 0 00.184-.518l-.693-3.04 2.268-2.032a.513.513 0 00.143-.532.48.48 0 00-.415-.342l-2.976-.25-1.147-2.885z"/>
                                </svg>
                                <span class="rating-text"><?php echo number_format($service['rating'], 2); ?> (<?php echo number_format($service['reviews']); ?> reviews)</span>
                            </div>
                            <div class="service-price-duration">
                                <div class="service-price-container">
                                    <span class="service-original-price">₹<?php echo number_format($service['original_price'], 2); ?></span>
                                    <span class="service-discounted-price">₹<?php echo number_format($service['discounted_price'], 2); ?></span>
                                </div>
                                <span class="service-duration">
                                    <svg class="duration-icon" viewBox="0 0 24 24" fill="#545454" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <?php echo htmlspecialchars($service['duration']); ?>
                                </span>
                            </div>
                            <div class="service-description">
                                <?php
                                $desc_items = explode('. ', $service['description']);
                                foreach ($desc_items as $item):
                                    if (trim($item)):
                                ?>
                                    <div class="description-item">
                                        <svg class="description-icon" viewBox="0 0 24 24" fill="#545454" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <?php echo htmlspecialchars(trim($item)); ?>
                                    </div>
                                <?php endif; endforeach; ?>
                            </div>
                        </div>
                        <div class="service-actions">
                            <button class="add-button" data-service-id="<?php echo $service['id']; ?>" aria-label="Add">Add</button>
                            <div class="quantity-control" style="display: none;">
                                <button class="quantity-button decrease" aria-label="Decrease quantity">
                                    <svg viewBox="0 0 24 24" fill="#6e42e5" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M20.25 13H3.75v-2h16.5v2z"/>
                                    </svg>
                                </button>
                                <span class="quantity-display">1</span>
                                <button class="quantity-button increase" aria-label="Increase quantity">
                                    <svg viewBox="0 0 24 24" fill="#6e42e5" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11 13v7.25h2V13h7.25v-2H13V3.75h-2V11H3.75v2H11z"/>
                                    </svg>
                                </button>
                            </div>
                            <button class="view-details-button" data-service-id="<?php echo $service['id']; ?>" aria-label="View Details">View details</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <h2>Add-on</h2>
        <div class="all_service-card">
            <?php
            $stmt = $conn->prepare("SELECT * FROM services WHERE category = 'women_add-on'");

            $stmt->execute();
            $services = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($services as $service):
                // Handle image path: Use full path from DB, fallback to assets/images if legacy
                $image_path = strpos($service['image'], 'uploads/') === 0 ? BASE_PATH . $service['image'] : BASE_PATH . 'assets/images/' . $service['image'];
            ?>
                <div class="service-card" id="card-<?php echo $service['id']; ?>" aria-label="<?php echo htmlspecialchars($service['title']); ?>">
                    <div class="service-image">
                        <img src="<?php echo htmlspecialchars($image_path); ?>" alt="<?php echo htmlspecialchars($service['title']); ?>" />
                    </div>
                    <div class="service-details">
                        <div>
                            <h2 class="service-title"><?php echo htmlspecialchars($service['title']); ?></h2>
                            <div class="service-rating">
                                <svg class="rating-icon" viewBox="0 0 20 20" fill="#572AC8" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M18.333 10a8.333 8.333 0 11-16.667 0 8.333 8.333 0 0116.667 0zm-7.894-4.694A.476.476 0 009.999 5a.476.476 0 00-.438.306L8.414 8.191l-2.977.25a.48.48 0 00-.414.342.513.513 0 00.143.532l2.268 2.033-.693 3.039a.51.51 0 00.183.518.458.458 0 00.528.022L10 13.298l2.548 1.629a.458.458 0 00.527-.022.51.51 0 00.184-.518l-.693-3.04 2.268-2.032a.513.513 0 00.143-.532.48.48 0 00-.415-.342l-2.976-.25-1.147-2.885z"/>
                                </svg>
                                <span class="rating-text"><?php echo number_format($service['rating'], 2); ?> (<?php echo number_format($service['reviews']); ?> reviews)</span>
                            </div>
                            <div class="service-price-duration">
                                <div class="service-price-container">
                                    <span class="service-original-price">₹<?php echo number_format($service['original_price'], 2); ?></span>
                                    <span class="service-discounted-price">₹<?php echo number_format($service['discounted_price'], 2); ?></span>
                                </div>
                                <span class="service-duration">
                                    <svg class="duration-icon" viewBox="0 0 24 24" fill="#545454" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <?php echo htmlspecialchars($service['duration']); ?>
                                </span>
                            </div>
                            <div class="service-description">
                                <?php
                                $desc_items = explode('. ', $service['description']);
                                foreach ($desc_items as $item):
                                    if (trim($item)):
                                ?>
                                    <div class="description-item">
                                        <svg class="description-icon" viewBox="0 0 24 24" fill="#545454" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <?php echo htmlspecialchars(trim($item)); ?>
                                    </div>
                                <?php endif; endforeach; ?>
                            </div>
                        </div>
                        <div class="service-actions">
                            <button class="add-button" data-service-id="<?php echo $service['id']; ?>" aria-label="Add">Add</button>
                            <div class="quantity-control" style="display: none;">
                                <button class="quantity-button decrease" aria-label="Decrease quantity">
                                    <svg viewBox="0 0 24 24" fill="#6e42e5" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M20.25 13H3.75v-2h16.5v2z"/>
                                    </svg>
                                </button>
                                <span class="quantity-display">1</span>
                                <button class="quantity-button increase" aria-label="Increase quantity">
                                    <svg viewBox="0 0 24 24" fill="#6e42e5" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11 13v7.25h2V13h7.25v-2H13V3.75h-2V11H3.75v2H11z"/>
                                    </svg>
                                </button>
                            </div>
                            <button class="view-details-button" data-service-id="<?php echo $service['id']; ?>" aria-label="View Details">View details</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <h2>Skin-care & scrubs</h2>
        <div class="all_service-card">
            <?php
            $stmt = $conn->prepare("SELECT * FROM services WHERE category = 'women_skin-care_scrubs'");

            $stmt->execute();
            $services = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($services as $service):
                // Handle image path: Use full path from DB, fallback to assets/images if legacy
                $image_path = strpos($service['image'], 'uploads/') === 0 ? BASE_PATH . $service['image'] : BASE_PATH . 'assets/images/' . $service['image'];
            ?>
                <div class="service-card" id="card-<?php echo $service['id']; ?>" aria-label="<?php echo htmlspecialchars($service['title']); ?>">
                    <div class="service-image">
                        <img src="<?php echo htmlspecialchars($image_path); ?>" alt="<?php echo htmlspecialchars($service['title']); ?>" />
                    </div>
                    <div class="service-details">
                        <div>
                            <h2 class="service-title"><?php echo htmlspecialchars($service['title']); ?></h2>
                            <div class="service-rating">
                                <svg class="rating-icon" viewBox="0 0 20 20" fill="#572AC8" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M18.333 10a8.333 8.333 0 11-16.667 0 8.333 8.333 0 0116.667 0zm-7.894-4.694A.476.476 0 009.999 5a.476.476 0 00-.438.306L8.414 8.191l-2.977.25a.48.48 0 00-.414.342.513.513 0 00.143.532l2.268 2.033-.693 3.039a.51.51 0 00.183.518.458.458 0 00.528.022L10 13.298l2.548 1.629a.458.458 0 00.527-.022.51.51 0 00.184-.518l-.693-3.04 2.268-2.032a.513.513 0 00.143-.532.48.48 0 00-.415-.342l-2.976-.25-1.147-2.885z"/>
                                </svg>
                                <span class="rating-text"><?php echo number_format($service['rating'], 2); ?> (<?php echo number_format($service['reviews']); ?> reviews)</span>
                            </div>
                            <div class="service-price-duration">
                                <div class="service-price-container">
                                    <span class="service-original-price">₹<?php echo number_format($service['original_price'], 2); ?></span>
                                    <span class="service-discounted-price">₹<?php echo number_format($service['discounted_price'], 2); ?></span>
                                </div>
                                <span class="service-duration">
                                    <svg class="duration-icon" viewBox="0 0 24 24" fill="#545454" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <?php echo htmlspecialchars($service['duration']); ?>
                                </span>
                            </div>
                            <div class="service-description">
                                <?php
                                $desc_items = explode('. ', $service['description']);
                                foreach ($desc_items as $item):
                                    if (trim($item)):
                                ?>
                                    <div class="description-item">
                                        <svg class="description-icon" viewBox="0 0 24 24" fill="#545454" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <?php echo htmlspecialchars(trim($item)); ?>
                                    </div>
                                <?php endif; endforeach; ?>
                            </div>
                        </div>
                        <div class="service-actions">
                            <button class="add-button" data-service-id="<?php echo $service['id']; ?>" aria-label="Add">Add</button>
                            <div class="quantity-control" style="display: none;">
                                <button class="quantity-button decrease" aria-label="Decrease quantity">
                                    <svg viewBox="0 0 24 24" fill="#6e42e5" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M20.25 13H3.75v-2h16.5v2z"/>
                                    </svg>
                                </button>
                                <span class="quantity-display">1</span>
                                <button class="quantity-button increase" aria-label="Increase quantity">
                                    <svg viewBox="0 0 24 24" fill="#6e42e5" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11 13v7.25h2V13h7.25v-2H13V3.75h-2V11H3.75v2H11z"/>
                                    </svg>
                                </button>
                            </div>
                            <button class="view-details-button" data-service-id="<?php echo $service['id']; ?>" aria-label="View Details">View details</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>

   <!-- Overlay for View Details -->
    <div class="overlay" id="serviceOverlay">
        <button class="overlay-close" id="closeOverlay">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M18 6L6 18M6 6l12 12" stroke="#545454" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
        <div class="overlay-content">
            <!-- details slider -->
            <img src="<?php echo BASE_PATH; ?>assets/images/wallpaint.jpg" alt="Service Image" class="overlay-image">                     
            <div class="overlay-details">
                <h2 class="overlay-title">Foam-jet AC Service</h2>
                <div class="overlay-rating">
                    <svg viewBox="0 0 20 20" fill="#572AC8" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M18.333 10a8.333 8.333 0 11-16.667 0 8.333 8.333 0 0116.667 0zm-7.894-4.694A.476.476 0 009.999 5a.476.476 0 00-.438.306L8.414 8.191l-2.977.25a.48.48 0 00-.414.342.513.513 0 00.143.532l2.268 2.033-.693 3.039a.51.51 0 00.183.518.458.458 0 00.528.022L10 13.298l2.548 1.629a.458.458 0 00.527-.022.51.51 0 00.184-.518l-.693-3.04 2.268-2.032a.513.513 0 00.143-.532.48.48 0 00-.415-.342l-2.976-.25-1.147-2.885z"/>
                    </svg>
                    <span class="overlay-rating-text">4.71 (3.4M reviews)</span>
                </div>
                <div class="overlay-benefit">Add more & save up to 17%</div>
                <p class="overlay-description">Dust-free filters & better airflow</p>
                <!-- Adding more content to demonstrate scrolling -->
                <p class="overlay-description">This service x a thorough cleaning of your AC unit using advanced foam-jet technology. It ensures that all dust and debris are removed from the filters, improving the airflow and cooling efficiency of your AC. Our professionals are trained to handle all types of AC units, ensuring a hassle-free experience.</p>
                <pass="overlay-description">Additional benefits include a 30-day service guarantee, free inspection, and eco-friendly cleaning solutions. We also provide tips on maintaining your AC unit to extend its lifespan and improve performance.</p>
                <p class="overlay-description">Our service is available for both split and window ACs, and we offer flexible scheduling options to suit your convenience. Book now to experience the best AC service in town!</p>
                <p class="overlay-description">This is a demo content to show scrolling. You can add as much content as you want, and the overlay will handle it with a smooth scroll experience.</p>
                <div class="overlay-promise">
                    <h3 class="overlay-promise-title">Karfect Promise</h3>
                    <div class="overlay-promise-item">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 6L9 17l-5-5" stroke="#00A86B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Verified Professionals
                    </div>
                    <div class="overlay-promise-item">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 6L9 17l-5-5" stroke="#00A86B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Hassle Free Booking
                    </div>
                    <div class="overlay-promise-item">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 6L9 17l-5-5" stroke="#00A86B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Transparent Pricing
                    </div>
                    <!-- Adding more items to demonstrate scrolling -->
                    <div class="overlay-promise-item">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 6L9 17l-5-5" stroke="#00A86B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        30-Day Service Guarantee
                    </div>
                    <div class="overlay-promise-item">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 6L9 17l-5-5" stroke="#00A86B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Eco-Friendly Solutions
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../../../includes/footer.php'; ?>

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