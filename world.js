window.onload = function () {
    const countryButton = document.getElementById('lookup-country'); // Button for Lookup Country
    const citiesButton = document.getElementById('lookup-cities');   // Button for Lookup Cities
    const countryInput = document.getElementById('country');         // Input field
    const resultDiv = document.getElementById('result');             // Result div

    // Function to handle AJAX requests
    function performLookup(lookupType) {
        const country = countryInput.value.trim(); // Get input value and trim whitespace
        let url = `world.php?country=${encodeURIComponent(country)}`; // Base URL

        // Add the lookup parameter based on the type
        if (lookupType === "cities") {
            url += `&lookup=cities`;
        }

        // Create an XMLHttpRequest
        const xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) { // Request completed
                if (xhr.status === 200) { // Successful response
                    resultDiv.innerHTML = xhr.responseText; // Update result div
                } else {
                    resultDiv.innerHTML = `<p>Error fetching data. Status: ${xhr.status}</p>`;
                }
            }
        };

        // Configure and send the request
        xhr.open('GET', url, true); // Asynchronous GET request
        xhr.send();
    }

    // Add click event listener for Lookup Country button
    countryButton.addEventListener('click', function () {
        performLookup("country");
    });

    // Add click event listener for Lookup Cities button
    citiesButton.addEventListener('click', function () {
        performLookup("cities");
    });
};
