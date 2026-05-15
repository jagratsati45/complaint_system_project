<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Register Form</title>
    <link rel="stylesheet" href="register.css" />
    <style>
        .right-side-pop {
            position: fixed;
            top: 24px;
            right: 24px;
            background: #0f172a;
            color: #ffffff;
            padding: 14px 22px;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 500;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.18);
            z-index: 10000;
            opacity: 0;
            transform: translateY(-12px);
            transition: opacity 0.35s ease, transform 0.35s ease;
            visibility: hidden;
        }

        .right-side-pop.show {
            opacity: 1;
            transform: translateY(0);
            visibility: visible;
        }
    </style>
</head>

<body>
<div class="container">
    <form id="registerForm" class="register-form">
        <h1>Register</h1>

        <label><b>Name:</b></label>
        <input type="text" name="name" placeholder="Enter your name" required><br>

        <label><b>Email:</b></label>
        <input type="email" name="email" placeholder="Enter your email address" required><br>

        <label>Password:</label>
        <input type="password" name="password" placeholder="Enter your password" required><br>

        <label>Confirm Password:</label><br>
        <input type="password" name="confirm_password" placeholder="Confirm your password" required><br><br>

        <button type="submit">Register</button>

        <p class="login-link">
            Already have an account? <a href="login.php">Login</a>
        </p>
    </form>
</div>

<div id="alert-container" class="right-side-pop"></div>

<script>
document.getElementById("registerForm").addEventListener("submit", function(e){
    e.preventDefault();

    let formData = new FormData(this);

    fetch("auth/register_process.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        console.log("Server:", data);

        if(data === "email_exists"){
            showToast("Email already exists");
        }
        else if(data === "success_first_admin"){
          showToast("Registration successful. You are the first admin.");
          setTimeout(() => {
            window.location.href = "login.php";
          }, 1800);
        }
        else if(data === "success"){
            showToast("Registration successful");
            setTimeout(() => {
                window.location.href = "login.php";
            }, 1500);
        }
        else if(data === "invalid_email"){
            showToast("Invalid email format");
        }
        else if(data === "password_mismatch"){
            showToast("Passwords do not match");
        }
        else if(data === "weak_password"){
            showToast("Password must be at least 6 characters");
        }
        else if(data === "invalid_name"){
          showToast("Name must be at least 2 characters");
        }
        else{
            showToast("Error: " + data);
        }
    })
    .catch(err => {
        console.error(err);
        showToast("Something went wrong");
    });
});

function showToast(message){
    let toast = document.getElementById("alert-container");

    toast.innerText = message;
    toast.classList.add("show");

    setTimeout(() => {
        toast.classList.remove("show");
    }, 3000);
}
</script>

</body>
</html>