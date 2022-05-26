// Toggle show / hide password
const checkShowPassword = document.querySelector('#show-password')
const password = document.querySelector('#password')
const confirmPassword = document.querySelector('#confirm_password')
checkShowPassword.addEventListener('change', function() {
    if (this.checked == true) {
        password.setAttribute('type', 'text')
        if (confirmPassword) confirmPassword.setAttribute('type', 'text')
    } else {
        password.setAttribute('type', 'password')
        if (confirmPassword) confirmPassword.setAttribute('type', 'password')
    }
})