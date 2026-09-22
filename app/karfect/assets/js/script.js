// Common functions
const baseUrl = window.BASE_PATH || '';

function showError(message) {
    const errorMsg = document.getElementById('error-msg');
    errorMsg.textContent = message;
    errorMsg.style.display = 'block';
}

function hideError() {
    const errorMsg = document.getElementById('error-msg');
    errorMsg.style.display = 'none';
}

document.addEventListener('DOMContentLoaded', () => {
    // Register Page Logic
    if (document.getElementById('register-btn')) {
        const emailStep = document.getElementById('email-step');
        const otpStep = document.getElementById('otp-step');
        const passwordStep = document.getElementById('password-step');
        const registerBtn = document.getElementById('register-btn');
        const verifyOtpBtn = document.getElementById('verify-otp-btn');
        const completeSignupBtn = document.getElementById('complete-signup-btn');
        const resendOtpBtn = document.getElementById('resend-otp-btn');
        const timerDisplay = document.getElementById('timer');
        const stepTitle = document.getElementById('step-title');
        const emailInput = document.getElementById('email-input');
        const otpInputs = document.querySelectorAll('.otp-input');
        const passwordInput = document.getElementById('password-input');
        const confirmPasswordInput = document.getElementById('confirm-password-input');
        const nameInput = document.getElementById('name-input');

        const eyeSVG = `<svg class="w-[16px] h-[16px] text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/><path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>`;
        const eyeSlashSVG = `<svg class="w-[16px] h-[16px] text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path d="m4 15.6 l3.055-3.056A4.913 4.913 0 0 1 7 12.012a5.006 5.006 0 0 1 5-5c.178.009.356.027.532.054l1.744-1.744A8.973 8.973 0 0 0 12 5.012c-5.388 0-10 5.336-10 7A6.49 6.49 0 0 0 4 15.6Z"/><path d="m14.7 10.726 l4.995-5.007A.998.998 0 0 0 18.99 4a1 1 0 0 0-.71.305l-4.995 5.007a2.98 2.98 0 0 0-.588-.21l-.035-.01a2.981 2.981 0 0 0-3.584 3.583c0 .012.008.022.01.033.05.204.12.402.211.59l-4.995 4.983a1 1 0 0 0 1.414 1.414l4.995-4.983c.189.091.386.162.59.211.011 0 .021.007.033.01a2.982 2.982 0 0 0 3.584-3.584c0-.012-.008-.023-.011-.035a3.05 3.05 0 0 0-.21-.588Z"/><path d="m19.821 8.605-2.857 2.857a4.952 4.952 0 0 1-5.514 5.514l-1.785 1.785c.767.166 1.55.25 2.335.251 6.453 0 10-5.258 10-7 0-1.166-1.637-2.874-2.179-3.407Z"/></svg>`;

        const togglePassword = document.getElementById('toggle-password');
        const toggleConfirmPassword = document.getElementById('toggle-confirm-password');

        if (togglePassword) {
            togglePassword.innerHTML = eyeSVG;
            togglePassword.addEventListener('click', () => {
                const type = passwordInput.type === 'password' ? 'text' : 'password';
                passwordInput.type = type;
                togglePassword.innerHTML = type === 'password' ? eyeSVG : eyeSlashSVG;
            });
        }

        if (toggleConfirmPassword) {
            toggleConfirmPassword.innerHTML = eyeSVG;
            toggleConfirmPassword.addEventListener('click', () => {
                const type = confirmPasswordInput.type === 'password' ? 'text' : 'password';
                confirmPasswordInput.type = type;
                toggleConfirmPassword.innerHTML = type === 'password' ? eyeSVG : eyeSlashSVG;
            });
        }

        let timer;

        function startTimer() {
            let timeLeft = 30;
            resendOtpBtn.disabled = true;
            resendOtpBtn.classList.remove('enabled');
            timerDisplay.textContent = `${timeLeft}s`;

            timer = setInterval(() => {
                timeLeft--;
                timerDisplay.textContent = `${timeLeft}s`;
                if (timeLeft <= 0) {
                    clearInterval(timer);
                    resendOtpBtn.disabled = false;
                    resendOtpBtn.classList.add('enabled');
                    timerDisplay.textContent = '0s';
                }
            }, 1000);
        }

        registerBtn.addEventListener('click', async () => {
            hideError();
            if (!emailInput.value) {
                showError('Email is required');
                return;
            }
            registerBtn.disabled = true;
            registerBtn.innerHTML = 'Sign Up with Email <span class="spinner"></span>';

            const response = await fetch(baseUrl + 'api/auth/send_otp.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `email=${encodeURIComponent(emailInput.value)}`
            });
            const data = await response.json();
            console.log(data);
            registerBtn.disabled = false;
            registerBtn.innerHTML = 'Sign Up with Email';

            if (data.status === 'success') {
                emailStep.classList.add('hidden');
                otpStep.classList.remove('hidden');
                stepTitle.textContent = 'Enter the 4-digit OTP';
                startTimer();
            } else {
                showError(data.message);
            }
        });

        resendOtpBtn.addEventListener('click', async () => {
            hideError();
            if (!emailInput.value) {
                showError('Email is missing');
                return;
            }
            resendOtpBtn.disabled = true;
            resendOtpBtn.innerHTML = 'Sending <span class="spinner"></span>';

            const response = await fetch(baseUrl + 'api/auth/send_otp.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `email=${encodeURIComponent(emailInput.value)}`
            });
            const data = await response.json();
            resendOtpBtn.disabled = false;
            resendOtpBtn.innerHTML = 'Resend OTP';

            if (data.status === 'success') {
                startTimer();
                showError('OTP resent successfully');
            } else {
                showError(data.message);
            }
        });

        otpInputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                if (e.target.value.length === 1 && index < 3) {
                    otpInputs[index + 1].focus();
                }
            });
        });

        verifyOtpBtn.addEventListener('click', async () => {
            hideError();
            const otp = Array.from(otpInputs).map(input => input.value).join('');
            if (otp.length !== 4) {
                showError('Please enter a 4-digit OTP');
                return;
            }

            verifyOtpBtn.disabled = true;
            verifyOtpBtn.innerHTML = 'Verifying <span class="spinner"></span>';

            const response = await fetch(baseUrl + 'api/auth/verify_otp.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `otp=${otp}`
            });
            const data = await response.json();
            verifyOtpBtn.disabled = false;
            verifyOtpBtn.innerHTML = 'Verify OTP';

            if (data.status === 'success') {
                otpInputs.forEach(input => input.classList.add('valid'));
                otpStep.classList.add('hidden');
                passwordStep.classList.remove('hidden');
                stepTitle.textContent = 'Set your password';
                clearInterval(timer);
            } else {
                showError(data.message);
            }
        });

        completeSignupBtn.addEventListener('click', async () => {
            hideError();
            const name = nameInput.value;
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;

            if (!name) {
                showError('Name is required');
                return;
            }
            if (!password || !confirmPassword) {
                showError('Both password fields are required');
                return;
            }
            if (password !== confirmPassword) {
                showError('Passwords do not match');
                return;
            }

            completeSignupBtn.disabled = true;
            completeSignupBtn.innerHTML = 'Completing <span class="spinner"></span>';

            const response = await fetch(baseUrl + 'api/auth/complete_signup.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `name=${encodeURIComponent(name)}&password=${encodeURIComponent(password)}&confirm_password=${encodeURIComponent(confirmPassword)}`
            });
            const data = await response.json();
            completeSignupBtn.disabled = false;
            completeSignupBtn.innerHTML = 'Complete Sign Up';

            if (data.status === 'success') {
                window.location.href = baseUrl + 'index.php';
            } else {
                showError(data.message);
            }
        });

        // Google Sign-in Logic
        const CLIENT_ID = window.GOOGLE_CLIENT_ID || '';
        const googleSigninBtn = document.getElementById('google-signin-btn');
        if (googleSigninBtn) {
            googleSigninBtn.addEventListener('click', () => {
                const redirectUri = window.location.origin + '/api/auth/google-callback.php';
                const scope = 'email profile';
                const authUrl = `https://accounts.google.com/o/oauth2/v2/auth?client_id=${CLIENT_ID}&redirect_uri=${encodeURIComponent(redirectUri)}&response_type=code&scope=${encodeURIComponent(scope)}&prompt=select_account`;
                window.location.href = authUrl;
            });
        }
    }

    // Login Page Logic
    if (document.getElementById('login-btn')) {
        const loginBtn = document.getElementById('login-btn');
        const emailInput = document.getElementById('email-input');
        const passwordInput = document.getElementById('password-input');
        const togglePassword = document.getElementById('toggle-password');

        const eyeSVG = `<svg class="w-[16px] h-[16px] text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/><path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>`;
        const eyeSlashSVG = `<svg class="w-[16px] h-[16px] text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path d="m4 15.6 l3.055-3.056A4.913 4.913 0 0 1 7 12.012a5.006 5.006 0 0 1 5-5c.178.009.356.027.532.054l1.744-1.744A8.973 8.973 0 0 0 12 5.012c-5.388 0-10 5.336-10 7A6.49 6.49 0 0 0 4 15.6Z"/><path d="m14.7 10.726 l4.995-5.007A.998.998 0 0 0 18.99 4a1 1 0 0 0-.71.305l-4.995 5.007a2.98 2.98 0 0 0-.588-.21l-.035-.01a2.981 2.981 0 0 0-3.584 3.583c0 .012.008.022.01.033.05.204.12.402.211.59l-4.995 4.983a1 1 0 0 0 1.414 1.414l4.995-4.983c.189.091.386.162.59.211.011 0 .021.007.033.01a2.982 2.982 0 0 0 3.584-3.584c0-.012-.008-.023-.011-.035a3.05 3.05 0 0 0-.21-.588Z"/><path d="m19.821 8.605-2.857 2.857a4.952 4.952 0 0 1-5.514 5.514l-1.785 1.785c.767.166 1.55.25 2.335.251 6.453 0 10-5.258 10-7 0-1.166-1.637-2.874-2.179-3.407Z"/></svg>`;

        if (togglePassword) {
            togglePassword.innerHTML = eyeSVG;
            togglePassword.addEventListener('click', () => {
                const type = passwordInput.type === 'password' ? 'text' : 'password';
                passwordInput.type = type;
                togglePassword.innerHTML = type === 'password' ? eyeSVG : eyeSlashSVG;
            });
        }

        loginBtn.addEventListener('click', async () => {
            hideError();
            const email = emailInput.value;
            const password = passwordInput.value;

            if (!email) {
                showError('Email is required');
                return;
            }
            if (!password) {
                showError('Password is required');
                return;
            }

            loginBtn.disabled = true;
            loginBtn.innerHTML = 'Signing In <span class="spinner"></span>';

            const response = await fetch(baseUrl + 'includes/process_login.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
            });
            const data = await response.json();
            loginBtn.disabled = false;
            loginBtn.innerHTML = 'Sign In with Email';

            if (data.status === 'success') {
                window.location.href = baseUrl + 'index.php';
            } else {
                showError(data.message);
            }
        });

        // Google Sign-in Logic
        const CLIENT_ID = window.GOOGLE_CLIENT_ID || '';
        const googleSigninBtn = document.getElementById('google-signin-btn');
        if (googleSigninBtn) {
            googleSigninBtn.addEventListener('click', () => {
                const redirectUri = baseUrl + 'api/auth/google-callback.php';
                const scope = 'email profile';
                const authUrl = `https://accounts.google.com/o/oauth2/v2/auth?client_id=${CLIENT_ID}&redirect_uri=${encodeURIComponent(redirectUri)}&response_type=code&scope=${encodeURIComponent(scope)}&prompt=select_account`;
                window.location.href = authUrl;
            });
        }
    }
});
