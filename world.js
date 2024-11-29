// world.js

window.onload = function () {
    const lookupButton = document.getElementById('lookup');
    const countryInput = document.getElementById('country');
    const resultDiv = document.getElementById('result');

    // Add a click event listener to the button
    lookupButton.addEventListener('click', function () {
        const country = countryInput.value.trim(); // Get input value and trim whitespace
        const url = `world.php?country=${encodeURIComponent(country)}`; // Encode user input for URL
        
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
    });
};
