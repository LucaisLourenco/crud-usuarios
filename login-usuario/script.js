$(document).ready(function() {
    $('form').submit(function(event) {
        event.preventDefault(); 

        var email = $('#email').val();
        var senha = $('#senha').val(); 

        $.ajax({
            url: 'controller.php',
            method: 'POST',
            data: { email: email, senha: senha },
            success: function(response) {
                if (response === 'success') {
                    window.location.href = 'dashboard.php';
                } else {
                    console.log(response);
                }
            }
        });
    });
});

var logoutButton = document.getElementById('logout-btn');

logoutButton.addEventListener('click', function() {
    var request = new XMLHttpRequest();
    request.open('POST', 'logout.php');
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    request.onload = function() {
        if (request.status === 200) {
            window.location.href = 'login.php';
        }
    };

    request.send();
});