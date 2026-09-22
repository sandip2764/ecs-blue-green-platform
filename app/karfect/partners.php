<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partners Section</title>
    <style>

        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Geist:wght@100..900&display=swap');

        * {
            padding: 0%;
            margin: 0%;
            text-decoration: none;
            list-style-type: none;
            box-sizing: border-box;
            border: none;
            font-family: "Geist", sans-serif;
        }
        .partners-section {
            padding: 60px 20px;
            text-align: center;
            background: #fff;
        }
        .partners-section h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 10px;
        }
        .partners-section p {
            font-size: 1rem;
            color: #6b7280;
            max-width: 700px;
            margin: 0 auto 40px;
            line-height: 1.5;
        }
        .partners-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 20px;
            max-width: 800px;
            margin: 0 auto;
        }
        .partner-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            height: 60px;
        }
        .partner-logo img {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
        }
        @media (max-width: 768px) {
            .partner-logo {
                height: 30px;
            }
            .partners-section h2 {
                font-size: 2rem;
            }
            .partners-section p {
                font-size: 0.9rem;
            }
        }
        @media (max-width: 480px) {
            .partner-logo {
                height: 20px;
            }
            .partners-section h2 {
                font-size: 1.5rem;
            }
            .partners-section p {
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <section class="partners-section">
        <h2>Our Partners</h2>
        <p>As a user, it is important to have a positive experience when using a website or app.</p>
        <div class="partners-grid">
            <div class="partner-logo"><img src="assets/images/upwork.png" alt="spotify"></div>
            <div class="partner-logo"><img src="assets/images/amazon.png" alt="amazon"></div>
            <div class="partner-logo"><img src="assets/images/google.png" alt="google"></div>
            <div class="partner-logo"><img src="assets/images/jobify.png" alt="uber"></div>
            <div class="partner-logo"><img src="assets/images/paypal.png" alt="paypal"></div>
        </div>
    </section>
</body>
</html>