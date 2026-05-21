document.addEventListener("DOMContentLoaded", function() {
    
    const elementeExpandabile = document.querySelectorAll(".expandabil");

    elementeExpandabile.forEach(function(element) {
        
        element.addEventListener("click", function(event) {
            event.stopPropagation(); 
            this.classList.toggle("deschis");
        });
    });

});