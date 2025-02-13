document.addEventListener('DOMContentLoaded', function() {
    const bar = document.getElementById("bar");
    const nav = document.getElementById("navbar");

    if (bar) {
        bar.addEventListener("click", function() {
            nav.classList.toggle("active");
        })
    }
})

document.addEventListener("DOMContentLoaded", function() {
    var MainImg = document.getElementById("MainImg");
    var SmallImg = document.getElementsByClassName("small-img");

    for (var i = 0; i < SmallImg.length; i++) {
        SmallImg[i].onclick = function() {
            MainImg.src = this.src; // Use 'this' to refer to the clicked small image
        };
    }
});

$(function() {
    // Initialize the accordion
    $("#accordion").accordion({
        heightStyle: "content",
        collapsible: true,
        beforeActivate: function(event, ui) {
            if (ui.newPanel.length) {
                ui.newPanel.fadeIn().fadeIn(200);
            }
            if (ui.oldPanel.length) {
                ui.oldPanel.stop(true, true).fadeOut(0);
            }
        }
    });
});

