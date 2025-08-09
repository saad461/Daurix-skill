<div class="text-center mb-4">
    <img src="/assets/images/logo.svg" alt="DaurixSkills Logo" height="50">
    <h1 class="h3 my-3 fw-normal">Welcome Back!</h1>
</div>

<div id="teddy-container" style="width: 200px; height: 150px; margin: auto;"></div>

<div class="card card-neumorphic">
    <div class="card-body p-4">
        <form id="loginForm" action="/login" method="POST">
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                <label for="email">Email address</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                <label for="password">Password</label>
            </div>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger animate__animated animate__shakeX" role="alert">
                    Invalid credentials. Please try again.
                </div>
            <?php endif; ?>

            <button class="w-100 btn btn-lg btn-primary animate__animated" type="submit">Sign in</button>
        </form>
        <div class="text-center mt-3">
            <a href="/register">Don't have an account? Sign up</a>
        </div>
    </div>
</div>

<script>
    const teddyContainer = document.getElementById('teddy-container');
    const anim = lottie.loadAnimation({
        container: teddyContainer,
        renderer: 'svg',
        loop: false,
        autoplay: false,
        path: '/assets/lottie/teddy.json'
    });

    // Check for error and play animation
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('error')) {
        // Play a segment of the Lottie animation that looks like a head shake
        anim.playSegments([0, 30], true);

        // Also add shake animation to form
        document.getElementById('loginForm').classList.add('animate__shakeX');
    }

    // A simple interaction: eyes follow mouse in the password field
    const passwordInput = document.getElementById('password');
    passwordInput.addEventListener('focus', () => {
        // Placeholder for eye-following logic
        anim.playSegments([30, 60], true); // Play a 'looking' segment
    });

</script>
