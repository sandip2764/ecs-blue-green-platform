<!-- Sidebar HTML -->
<div class="sidebar" id="sidebar">
    <div class="p-0 border-b">
        <img src="logo1.png" alt="Logo" class="img-fluid" style="margin: 0px 5px 5px 5px; max-width: 150px">
        <!--<h6 class="text-2xl font-bold text-var(--primary)"> Admin</h6>-->
    </div>
    <nav class="mt-3">
        <a href="index.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : ''; ?>">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Dashboard
        </a>
        <a href="services.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'services.php' ? 'active' : ''; ?>">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            Services
        </a>
        <a href="workers.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'workers.php' ? 'active' : ''; ?>">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            Workers
        </a>
        <a href="bookings.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'bookings.php' ? 'active' : ''; ?>">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M8 7V3m8 4V3M3 11h18M5 19h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
            </svg>
            Bookings
        </a>

        <a href="settings.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'settings.php' ? 'active' : ''; ?>">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.573-1.066z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Settings
        </a>
        <a href="logout.php">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            Logout
        </a>
    </nav>
</div>

<style>
    /* Root Variables */
:root {
    --primary: #1a73e8; /* Google Blue */
    --primary-dark: #1557b0; /* Darker shade for hover */
    --text-dark: #202124; /* Google's dark text */
    --text-light: #5f6368; /* Google's secondary text */
    --background: #f5f7fa; /* Light background */
    --card-bg: #ffffff; /* White card background */
    --border: #dadce0; /* Subtle border color */
    --shadow: rgba(0, 0, 0, 0.08); /* Soft shadow */
    --transition: cubic-bezier(0.2, 0, 0, 1); /* Smooth Google easing */
}

/* Sidebar */
.sidebar {
    width: 250px;
    height: 100vh;
    background: var(--card-bg);
    position: fixed;
    left: 0;
    top: 0;
    border-right: 1px solid var(--border);
    transition: transform 0.3s var(--transition);
    font-family: 'Roboto', -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif;
    z-index: 1000;
    overflow-y: auto;
}

.sidebar.hidden {
    transform: translateX(-250px);
}

.sidebar .p-0.border-b {
    padding: 16px;
    border-bottom: 1px solid var(--border);
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.sidebar img {
    max-width: 140px;
    height: auto;
    transition: transform 0.2s var(--transition);
}

.sidebar img:hover {
    transform: scale(1.02);
}

.sidebar nav {
    padding: 8px;
    margin-top: 8px;
}

.sidebar nav a {
    display: flex;
    align-items: center;
    padding: 8px 16px;
    color: var(--text-light);
    font-size: 14px;
    font-weight: 400;
    text-decoration: none;
    border-radius: 8px;
    margin-bottom: 4px;
    transition: background-color 0.2s var(--transition), color 0.2s var(--transition);
    position: relative;
    overflow: hidden;
}

.sidebar nav a:hover {
    background-color: #e8f0fe;
    color: var(--text-dark);
}

.sidebar nav a.active {
    background: #e8f0fe;
    color: var(--primary);
    font-weight: 500;
}

.sidebar nav a.active::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background: var(--primary);
    border-radius: 0 4px 4px 0;
}

.sidebar nav a svg {
    width: 20px;
    height: 20px;
    margin-right: 12px;
    stroke: var(--text-light);
    stroke-width: 1.5;
    transition: stroke 0.2s var(--transition);
}

.sidebar nav a.active svg {
    stroke: var(--primary);
}

.sidebar nav a:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(26, 115, 232, 0.3);
}

.sidebar nav a::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    background: rgba(26, 115, 232, 0.2);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    transition: width 0.4s var(--transition), height 0.4s var(--transition);
    pointer-events: none;
}

.sidebar nav a:active::after {
    width: 200px;
    height: 200px;
}

.sidebar::-webkit-scrollbar {
    width: 6px;
}

.sidebar::-webkit-scrollbar-track {
    background: var(--background);
}

.sidebar::-webkit-scrollbar-thumb {
    background: var(--text-light);
    border-radius: 3px;
}

.sidebar::-webkit-scrollbar-thumb:hover {
    background: var(--text-dark);
}

/* Responsive Design */
@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-250px);
        box-shadow: 0 4px 16px var(--shadow);
    }

    .sidebar.active {
        transform: translateX(0);
    }
}
</style>

<script>
    // Sidebar toggle
    document.addEventListener('DOMContentLoaded', () => {
        const toggleButton = document.getElementById('toggle-sidebar');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');

        if (toggleButton) {
            toggleButton.addEventListener('click', () => {
                sidebar.classList.toggle('active');
                mainContent.classList.toggle('full');
            });
        }

        // Optional: Close sidebar when clicking a menu item on mobile
        const menuLinks = sidebar.querySelectorAll('nav a');
        menuLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('active');
                    mainContent.classList.remove('full');
                }
            });
        });
    });
</script>