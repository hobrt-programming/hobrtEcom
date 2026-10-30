        // Get references to the button and content elements
        const toggleButton = document.getElementById("toggleButton");
        const contentToDisplay = document.getElementById("buy");

        // Add a click event listener to the button
        // only product pages have the order toggle
        if (toggleButton && contentToDisplay) toggleButton.addEventListener("click", function() {
            // Toggle the display property of the content
            if (contentToDisplay.style.display === "none") {
                contentToDisplay.style.display = "block";
            } else {
                contentToDisplay.style.display = "none";
            }
        });