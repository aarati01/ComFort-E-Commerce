// Modal 1
var modal = document.getElementById("myModal");
var span = document.getElementsByClassName("close")[0];

function openModal() {
    modal.style.display = "block";
}

span.onclick = function() {
    modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

// Modal 2
var modal_2 = document.getElementById("myModal_2");
var span_2 = document.getElementsByClassName("close_2")[0];

function openModal_2() {
    modal_2.style.display = "block";
}

span_2.onclick = function() {
    modal_2.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal_2) {
        modal_2.style.display = "none";
    }
}

// Modal 3
var modal_3 = document.getElementById("myModal_3");
var span_3 = document.getElementsByClassName("close_3")[0];

function openModal_3() {
    modal_3.style.display = "block";
}

span_3.onclick = function() {
    modal_3.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal_3) {
        modal_3.style.display = "none";
    }
}

// Modal 4
var modal_4 = document.getElementById("myModal_4");
var span_4 = document.getElementsByClassName("close_4")[0];

function openModal_4() {
    modal_4.style.display = "block";
}

span_4.onclick = function() {
    modal_4.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal_4) {
        modal_4.style.display = "none";
    }
}

// Handle form submission for account deletion
document.getElementById('deleteAccountForm').addEventListener('submit', function(event) {
    event.preventDefault();
    var confirmed = document.getElementById('confirm').checked;
    var message = document.getElementById('message');
    if (confirmed) {
        message.textContent = 'Account deleted successfully.';
    } else {
        message.textContent = 'Please confirm that you want to delete your account.';
    }
});

// Accordion functionality
$(document).ready(function() {
    $('.accordion-header').click(function() {
        $(this).parent().toggleClass('active');
        $(this).next('.accordion-content').slideToggle();
    });
});

// Photo Modal
$(document).ready(function() {
    $('#changePhotoBtn').click(function() {
        $('#photoModal').css('display', 'block');
    });
    $('.pclose, .pmodal').click(function(event) {
        if (event.target === this) {
            $('#photoModal').css('display', 'none');
        }
    });
    $('.photoOption').click(function() {
        var photoSrc = $(this).attr('src');
        $('#profileImage').attr('src', photoSrc);
        $('#photoModal').css('display', 'none');
    });
});

// Update Profile AJAX Request
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("updateBtn").addEventListener("click", function() {
        var firstName = document.getElementById("firstName").value;
        var lastName = document.getElementById("lastName").value;
        var formData = new FormData();
        formData.append("first_name", firstName);
        formData.append("last_name", lastName);
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "update_profile.php", true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                document.getElementById("updateMessage").innerHTML = xhr.responseText;
            } else {
                console.error(xhr.statusText);
            }
        };
        xhr.onerror = function() {
            console.error("Request failed");
        };
        xhr.send(formData);
    });
});

// Prevent default behavior for buttons, inputs, and links in widgets
$(function() {
    $(".widget input[type=submit], .widget a, .widget button").button();
    $("button, input, a").on("click", function(event) {
        event.preventDefault();
    });
});
