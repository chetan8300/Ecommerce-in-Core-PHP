function login() {
                var pattern = /^\w+\@[a-zA-Z_.]+\.\w{2,5}$/;
                var email = document.getElementById("email").value;
                var pwd = document.getElementById("password").value;
                if (email == "") {
                    document.getElementById("email").style.borderColor = "red";
                    document.getElementById("email_error").innerHTML = "Please Enter Email Address";
                    document.getElementById("email").focus();
                }
                else if (pattern.test(email) == false) {
                    document.getElementById("email").style.borderColor = "red";
                    document.getElementById("email_error").innerHTML = "Please Enter Valid Email Address";
                    document.getElementById("email").focus();
                }
                if (pwd == "") {
                    document.getElementById("password").style.borderColor = "red";
                    document.getElementById("pass_error").innerHTML = "Password Field can not be empty";
                    document.getElementById("password").focus();
                    return false;
                }
                else if (pwd.length<8){
                    document.getElementById("password").style.borderColor = "red";
                    document.getElementById("pass_error").innerHTML = "Password Field Should contain atleast 8 characters";
                    document.getElementById("password").focus();
                    return false;
                }
}
            function email_blank() {
                    document.getElementById("email_error").innerHTML = "";
                    document.getElementById("email").style.borderColor = "";
                    return false;
            }
            function pass_blank() {
                    document.getElementById("pass_error").innerHTML = "";
                    document.getElementById("password").style.borderColor = "";
                    return false;
            }
            function email_error(){
                var email = document.getElementById("email").value;
                if (email == "") {
                    document.getElementById("email_error").innerHTML = "Please Enter Email Address";
                    document.getElementById("email").style.borderColor = "red";
                    return false;
                }
            }
            function pass_error(){
                var password = document.getElementById("password").value;
                if (password == "") {
                    document.getElementById("pass_error").innerHTML = "Password Field can not be empty";
                    document.getElementById("password").style.borderColor = "red";
                    return false;
                }
            }
            
            
            
function register() {
                var pattern = /^\w+\@[a-zA-Z_.]+\.\w{2,5}$/;
                var fname = document.getElementById("fname").value;
                var lname = document.getElementById("lname").value;
                var email = document.getElementById("email").value;
                var pwd = document.getElementById("password").value;
                var cpwd = document.getElementById("con_password").value;
                if (fname == "") {
                    document.getElementById("fname_error").innerHTML = "Please Enter First Name";
                    document.getElementById("fname").style.borderColor = "red";
                    return false;
                }
                if (lname == "") {                   
                    document.getElementById("lname_error").innerHTML = "Please Enter Last Name";
                    document.getElementById("lname").style.borderColor = "red";
                    return false;
                }
                if (email == "") {
                    document.getElementById("email").style.borderColor = "red";
                    document.getElementById("email_error").innerHTML = "Please Enter Email Address";
                    return false;
                }
                else if (pattern.test(email) == false) {
                    document.getElementById("email").style.borderColor = "red";
                    document.getElementById("email_error").innerHTML = "Please Enter Valid Email Address";
                    return false;
                }
                if (pwd == "") {
                    document.getElementById("password").style.borderColor = "red";
                    document.getElementById("pass_error").innerHTML = "Password Field Can not be empty";
                    return false;
                }
                else if (pwd.length<8){
                    document.getElementById("password").style.borderColor = "red";
                    document.getElementById("pass_error").innerHTML = "Password Field Should contain atleast 8 characters";
                    return false;
                }
                if (cpwd == "") {
                    document.getElementById("con_password").style.borderColor = "red";
                    document.getElementById("cpass_error").innerHTML = "Password Field Can not be empty";
                    return false;
                }
                if (pwd != cpwd) {
                    document.getElementById("cpass_error").innerHTML = "Password and Confirm Password didn't match";
                    document.getElementById("con_password").style.borderColor = "red";
                    return false;
                }
                document.register_form.submit();
}


            function fname_blank() {
                    document.getElementById("fname_error").innerHTML = "";
                    document.getElementById("fname").style.borderColor = "";
                    return false;
            }
            function lname_blank() {
                    document.getElementById("lname_error").innerHTML = "";
                    document.getElementById("lname").style.borderColor = "";
                    return false;
            }
            function email_blank() {
                    document.getElementById("email_error").innerHTML = "";
                    document.getElementById("email").style.borderColor = "";
                    return false;
            }
            function pass_blank() {
                    document.getElementById("pass_error").innerHTML = "";
                    document.getElementById("password").style.borderColor = "";
                    return false;
            }
            function con_pass_blank() {
                    document.getElementById("cpass_error").innerHTML = "";
                    document.getElementById("con_password").style.borderColor = "";
                    return false;
            }
            
            function fname_error(){
                var fname = document.getElementById("fname").value;
                if (fname == "") {
                    document.getElementById("fname_error").innerHTML = "Please Enter First Name";
                    document.getElementById("fname").style.borderColor = "red";
                    return false;
                }
            }
            function lname_error(){
                var fname = document.getElementById("lname").value;
                if (fname == "") {
                    document.getElementById("lname_error").innerHTML = "Please Enter Last Name";
                    document.getElementById("lname").style.borderColor = "red";
                    return false;
                }
            }
            function email_error(){
                var fname = document.getElementById("email").value;
                if (fname == "") {
                    document.getElementById("email_error").innerHTML = "Please Enter Email Address";
                    document.getElementById("email").style.borderColor = "red";
                    return false;
                }
            }
            function pass_error(){
                var fname = document.getElementById("password").value;
                if (fname == "") {
                    document.getElementById("pass_error").innerHTML = "Please Enter Password";
                    document.getElementById("password").style.borderColor = "red";
                    return false;
                }
            }
            function cpass_error(){
                var fname = document.getElementById("con_password").value;
                if (fname == "") {
                    document.getElementById("cpass_error").innerHTML = "Please Enter Confirm Password";
                    document.getElementById("con_password").style.borderColor = "red";
                    return false;
                }
            }