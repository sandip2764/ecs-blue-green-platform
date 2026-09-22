<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>footer</title>
</head>
<body>
    
<style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Geist:wght@100..900&display=swap');

        * {
            padding: 0;
            margin: 0;
            text-decoration: none;
            list-style-type: none;
            box-sizing: border-box;
            border: none;
        }

        footer {
            background: #fff;
        }

        .karfect_logotext {
            color: #f5f5f5;
            width: 98vw;
            font-size: clamp(13vw, 13vw, 13vw);
            line-height: 1; 
            text-align: center;
            font-family: "Geist", sans-serif;
            padding-top: 20px;
        }

        .footer_sections {
            display: flex;
            justify-content: space-around;
            text-align: left;
            font-family: "Geist", sans-serif;
            color: #101010;
            padding: 20px; /* Added for better spacing */
        }

        .footer_sections h1 {
            font-weight: 500;
            font-size: 1.6rem;
            margin-bottom: 20px;
        }

        .footer_section1 p {
            color: #555555;
            margin-bottom: 8px;
            font-family: "Geist", sans-serif;
            text-align: left;
            font-size: 16px;
        }

        .social_containers {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .social-icons {
            height: 28px;
            width: 28px;
            border-radius: 4px;
            background: #101010;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .copyright {
            height: 60px;
            background: #757575;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: "Geist", sans-serif;
        }

        .mobile_version_option p {
            margin: 20px 0;
            color: #101010;
            font-size: 16px;
            font-weight: bold;
            text-decoration: underline;
        }

        .playstore {
            width: 62%;
            height: 10%;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        .playstore img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 4px;
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .footer_sections {
                display: flex;
                flex-wrap: wrap; 
                justify-content: space-between;
                padding: 24px;
            }

            .footer_section1 {
                width: 48%; /* Two sections per row */
                margin-bottom: 20px;
            }

            /* Company and For Customers in first column */
            .footer_section1:nth-child(1),
            .footer_section1:nth-child(2) {
                width: 48%; /* Full width for these sections */
            }

            /* For Partners and Social Links in second column */
            .footer_section1:nth-child(3),
            .footer_section1:nth-child(4) {
                width: 48%; /* Side by side in a row */
            }

            /* Adjust playstore image size for mobile */
            .playstore {
                width: 40%; /* Slightly larger for visibility */
                height: auto;
            }

            /* Ensure social icons remain readable */
            .social_containers {
                gap: 8px;
            }

            .app {
                display: flex;
                gap: 10px;
            }
            .copyright {
                height: 60px;
                margin-bottom: 60px;
            }
        }

        /* Extra small screens (e.g., <480px) */
        @media (max-width: 480px) {

            .footer_section1:nth-child(1),
            .footer_section1:nth-child(2) {
                width: 48%; 
            }

            .footer_section1:nth-child(3),
            .footer_section1:nth-child(4) {
                width: 48%; 
            }

            .playstore {
                width: 100%; 
                border-radius: 1px;
                
            }

            .footer_sections h1 {
                font-size: 1.1rem;
            }
            .app {
                display: flex;
                gap: 10px;
            }

            .footer_section1 p {
                font-size: 12px;
            }

            .copyright {
                height: 40px;
                margin-bottom: 60px;
            }
            .copyright p {
                font-size: 12px;
                
            }
        }

    </style>

    <!-- HTML (Unchanged) -->
   
    <footer>
        <div class="karfect_logotext">
            <h1>karfect</h1>
        </div>

        <div class="footer_elements">
            <div class="footer_sections">
                <div class="footer_section1">
                    <h1>Company</h1>
                    <a href="#"><p>About us</p></a>
                    <a href="#"><p>Terms & conditions</p></a>
                    <p>Privacy policy</p>
                    <a href="#"><p>Careers</p></a>
                </div>
                <div class="footer_section1">
                    <h1>For customers</h1>
                    <a href="#"><p>About us</p></a>
                    <a href="#"><p>Terms & conditions</p></a>
                    <a href="#"><p>Privacy policy</p></a>
                    <a href="#"><p>Careers</p></a>
                </div>
                <div class="footer_section1">
                    <h1>For partners</h1>
                    <a href="#"><p>About us</p></a>
                    <a href="#"><p>Terms & conditions</p></a>
                    <a href="#"><p>Careers</p></a>
                </div>
                <div class="footer_section1">
                    <h1>Social links</h1>
                    <div class="social_containers">
                        <a href="#">
                            <div class="social-icons">
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24">
                                    <path fill="#fff" fill-rule="evenodd" d="M3 8a5 5 0 0 1 5-5h8a5 5 0 0 1 5 5v8a5 5 0 0 1-5 5H8a5 5 0 0 1-5-5V8Zm5-3a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V8a3 3 0 0 0-3-3H8Zm7.597 2.214a1 1 0 0 1 1-1h.01a1 1 0 1 1 0 2h-.01a1 1 0 0 1-1-1ZM12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6Zm-5 3a5 5 0 1 1 10 0 5 5 0 0 1-10 0Z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </a>
                        <a href="#">
                            <div class="social-icons">
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ffffff" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M12.51 8.796v1.697a3.738 3.738 0 0 1 3.288-1.684c3.455 0 4.202 2.16 4.202 4.97V19.5h-3.2v-5.072c0-1.21-.244-2.766-2.128-2.766-1.827 0-2.139 1.317-2.139 2.676V19.5h-3.19V8.796h3.168ZM7.2 6.106a1.61 1.61 0 0 1-.988 1.483 1.595 1.595 0 0 1-1.743-.348A1.607 1.607 0 0 1 5.6 4.5a1.601 1.601 0 0 1 1.6 1.606Z" clip-rule="evenodd"/>
                                    <path d="M7.2 8.809H4V19.5h3.2V8.809Z"/>
                                </svg>
                            </div>
                        </a>
                        <a href="#">
                            <div class="social-icons">
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffffff" viewBox="0 0 24 24">
                                    <path d="M13.795 10.533 20.68 2h-3.073l-5.255 6.517L7.69 2H1l7.806 10.91L1.47 22h3.074l5.705-7.07L15.31 22H22l-8.205-11.467Zm-2.38 2.95L9.97 11.464 4.36 3.627h2.31l4.528 6.317 1.443 2.02 6.018 8.409h-2.31l-4.934-6.89Z"/>
                                </svg>
                            </div>
                        </a>
                    </div>

                    <div class="mobile_version_option">
                        <p>On the horizon</p>
                        <div class="app">
                            <div class="playstore">
                                <img src="<?php echo BASE_PATH; ?>assets/images/playstore-icon.webp" alt="Play Store">
                            </div>
                            <div class="playstore">
                                <img src="<?php echo BASE_PATH; ?>assets/images/app-store.icon.webp" alt="App Store">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="copyright">
            <p>© Copyright 2025 karfect. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>