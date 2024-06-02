var macAddressList = [];  // Declare an array to store the MAC addresses
var timer = null;  // Declare a timer variable outside the function

function addMacAddress(event) {


    var input = document.getElementById('barcodeInput');

    // Clear the previous timer if it exists
    if (timer !== null) {
        clearTimeout(timer);
    }

    // Start a new timer that waits for 0.5 seconds of inactivity
    timer = setTimeout(function() {
        var scannerInput = input.value;

        // Add the input value to the macAddressList
        macAddressList.push(scannerInput);

        // Clear the input field
        input.value = '';

        // Call a function to update the display
        displayMacAddresses();
    }, 150);  // 150 milliseconds = 0.15 seconds
}

function displayMacAddresses() {
    var macAddresses = document.getElementById('macAddresses');
    var greenButton = document.getElementById('greenButton');

    // Clear the current contents of the macAddresses div
    macAddresses.innerHTML = '';

    // Iterate over the macAddressList
    for (var i = 0; i < macAddressList.length; i++) {
        // Create a new span element to contain the text
        var span = document.createElement('span');

        // Apply styles to the span
        span.style.color = 'black';
        span.style.fontSize = '20px';
        span.style.fontFamily = 'Arial, sans-serif';

        // Add the MAC address to the span
        span.textContent = macAddressList[i];

        // Create a new button
        var button = document.createElement('button');
        button.textContent = '-';
        button.style.width = '50px';  // Increase the width
        button.style.height = '40px';  // Increase the height
        button.style.fontSize = '30px';  // Increase the font size
        button.style.borderRadius = '50%';
        button.style.textAlign = 'center';
        button.style.lineHeight = '20px';  // Adjust the line height
        button.style.backgroundColor = 'red';
        button.style.border = 'none';
        button.addEventListener('click', function() {
            // Remove the MAC address from the list when the button is clicked
            var index = macAddressList.indexOf(span.textContent);
            if (index > -1) {
                macAddressList.splice(index, 1);
            }

            // Update the display
            displayMacAddresses();
        });

        // Add the span and the button to the macAddresses div
        macAddresses.appendChild(span);
        macAddresses.appendChild(button);

        // Add a line break after the button
        macAddresses.appendChild(document.createElement('br'));
        macAddresses.appendChild(document.createElement('br'));
    }

    // Show or hide the green button based on the length of the macAddressList
    if (macAddressList.length > 0) {
        confirmButton.style.display = 'inline-block';
    } else {
        confirmButton.style.display = 'none';
    }
}

function sendData() {
    // Get the number of items in the macAddressList
    var numItems = macAddressList.length;

    // Show the custom confirmation dialog
    if (numItems <=1) {
        document.getElementById('confirmMessage').textContent = numItems + " item";
    } else {
        document.getElementById('confirmMessage').textContent = numItems + " items";
    }
    document.getElementById('confirmDialog').style.display = 'block';

    // Set up the Yes button
    document.getElementById('yesButton').onclick = function() {
        // If the user clicked Yes, clear the macAddressList and redirect to the confirmation page
        macAddressList = [];
        displayMacAddresses();
        window.location.href = "confirmationPage.html";
    };

    // Set up the No button
    document.getElementById('noButton').onclick = function() {
        // If the user clicked No, hide the dialog
        document.getElementById('confirmDialog').style.display = 'none';
    };
}



function modifyInventory(action) {
    var retrieveButton = document.getElementById('retrieveButton');
    var RefurbishButton = document.getElementById('RefurbishButton');

    if (action == "Retrieve") {
        console.log("retrieve items from inventory");
        retrieveButton.classList.add('selected');
        RefurbishButton.classList.remove('selected');
    }
    else if (action == "Refurbish") {
        console.log("Refurbish items to inventory");
        RefurbishButton.classList.add('selected');
        retrieveButton.classList.remove('selected');
    }
}

window.onload = function() {
    var user = JSON.parse(localStorage.getItem('selectedUser'));  // Retrieve the user object from localStorage
    if (user) {
        document.getElementById('myHeader').innerHTML = user.username + "'s Inventory";
    }

    // Select the Retrieve button by default
    document.getElementById('retrieveButton').classList.add('selected');
}


function goBack() {
    window.location.href = "index.html";
}
