document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            let isValid = true;

            // Name validation
            const nameFields = form.querySelectorAll('input[name*="name"]:not([name*="username"]), input[name*="department"]:not([name*="username"])');
            

            nameFields.forEach(field => {
                if (!/^[a-zA-Z\s]+$/.test(field.value)) {
                    showError(field, 'Name should only contain letters and spaces');
                    isValid = false;  
                }
            });

            // Username validation
            const usernameField = form.querySelector('input[name="username"]');
            if (usernameField && !/^[a-zA-Z0-9_]{3,20}$/.test(usernameField.value)) {
                showError(usernameField, 'Username should be 3-20 characters long and contain only letters, numbers, and underscores');
                isValid = false;
            }

            // Password validation
            const passwordField = form.querySelector('input[name="password"]');
            if (passwordField && !/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/.test(passwordField.value)) {
                showError(passwordField, 'Password must be at least 8 characters long and include uppercase, lowercase, number, and special character');
                isValid = false;
            }

            // Department name validation
            const departmentField = form.querySelector('input[name="department_name"]');
            if (departmentField && !/^[a-zA-Z\s]+$/.test(departmentField.value)) {
                showError(departmentField, 'Department name should only contain letters and spaces');
                isValid = false;
            }

            // Email validation
            const emailField = form.querySelector('input[type="email"]');
            if (emailField && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailField.value)) {
                showError(emailField, 'Please enter a valid email address');
                isValid = false;
            }

            if (!isValid) {
                event.preventDefault();
            }
        });
    });

    



    
});

function showError(field, message) {
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.textContent = message;
    errorDiv.style.color = 'red';
    errorDiv.style.fontSize = '0.8em';
    errorDiv.style.marginTop = '5px';
    field.parentNode.appendChild(errorDiv);
    field.style.borderColor = 'red';

    setTimeout(() => {
        errorDiv.remove();
        field.style.borderColor = '';
    }, 10000);
}






