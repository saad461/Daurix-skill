<div class="text-center mb-4">
    <img src="/assets/images/logo.svg" alt="DaurixSkills Logo" height="50">
    <h1 class="h3 my-3 fw-normal">Create Your Account</h1>
</div>

<div class="card card-neumorphic">
    <div class="card-body p-4">
        <form action="/register" method="POST">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="name" name="name" placeholder="John Doe" required>
                <label for="name">Full Name</label>
            </div>
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                <label for="email">Email address</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                <label for="password">Password</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                <label for="confirm_password">Confirm Password</label>
            </div>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger animate__animated animate__shakeX" role="alert">
                    <?php
                        $error = $_GET['error'];
                        switch ($error) {
                            case 'validation':
                                echo 'Please fill all fields correctly.';
                                break;
                            case 'email':
                                echo 'Please enter a valid email address.';
                                break;
                            case 'exists':
                                echo 'An account with this email already exists.';
                                break;
                            case 'server':
                                echo 'An internal server error occurred. Please try again later.';
                                break;
                            default:
                                echo 'An unknown error occurred.';
                        }
                    ?>
                </div>
            <?php endif; ?>

            <button class="w-100 btn btn-lg btn-primary" type="submit">Sign up</button>
        </form>
        <div class="text-center mt-3">
            <a href="/login">Already have an account? Sign in</a>
        </div>
    </div>
</div>
