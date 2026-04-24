function validateSignupForm() {
    let fullName = document.forms["signupForm"]["full_name"].value.trim();
    let email = document.forms["signupForm"]["email"].value.trim();
    let password = document.forms["signupForm"]["password"].value;
    let confirmPassword = document.forms["signupForm"]["confirm_password"].value;

    if (fullName === "" || email === "" || password === "" || confirmPassword === "") {
        alert("All fields are required.");
        return false;
    }

    let emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,}$/;
    if (!email.match(emailPattern)) {
        alert("Please enter a valid email address.");
        return false;
    }

    if (password.length < 6) {
        alert("Password must be at least 6 characters.");
        return false;
    }

    if (password !== confirmPassword) {
        alert("Passwords do not match.");
        return false;
    }

    return true;
}

function validateLoginForm() {
    let email = document.forms["loginForm"]["email"].value.trim();
    let password = document.forms["loginForm"]["password"].value;

    if (email === "" || password === "") {
        alert("Email and password are required.");
        return false;
    }

    return true;
}

function validateAreaForm() {
    let areaName = document.forms["areaForm"]["area_name"].value.trim();

    if (areaName === "") {
        alert("Area name is required.");
        return false;
    }

    return true;
}

function validateResidentForm() {
    let fullName = document.forms["residentForm"]["full_name"].value.trim();
    let email = document.forms["residentForm"]["email"].value.trim();
    let areaId = document.forms["residentForm"]["area_id"].value;

    if (fullName === "" || email === "" || areaId === "") {
        alert("Please fill all required fields.");
        return false;
    }

    let emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,}$/;
    if (!email.match(emailPattern)) {
        alert("Please enter a valid email address.");
        return false;
    }

    return true;
}

function validateCompanyForm() {
    let companyName = document.forms["companyForm"]["company_name"].value.trim();
    let areaId = document.forms["companyForm"]["area_id"].value;

    if (companyName === "" || areaId === "") {
        alert("Company name and area are required.");
        return false;
    }

    return true;
}

function validateProductForm() {
    let productName = document.forms["productForm"]["product_name"].value.trim();
    let category = document.forms["productForm"]["category"].value.trim();
    let type = document.forms["productForm"]["type"].value;
    let companyId = document.forms["productForm"]["company_id"].value;

    if (productName === "" || category === "" || type === "" || companyId === "") {
        alert("Please fill all required product fields.");
        return false;
    }

    return true;
}

function validateVoteForm() {
    let residentId = document.forms["voteForm"]["resident_id"].value;
    let productId = document.forms["voteForm"]["product_id"].value;

    if (residentId === "" || productId === "") {
        alert("Please select both resident and product.");
        return false;
    }

    return true;
}