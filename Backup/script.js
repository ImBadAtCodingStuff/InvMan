function selectUser(user) {
    if (user.username == 'Other') {
        confirm('this option is still in development. This option will show other users outside of OSP once i make it do that lol')
        window.location.href = 'index.html'
    } else {
        console.log(`Logging Inventory for user: ${user.username}`);
        localStorage.setItem('selectedUser', JSON.stringify(user));  // Store the user object in localStorage
        window.location.href = "InvMan.html";
    }
}


fetch('users.json')  // Replace 'users.json' with the path to your JSON file
    .then(response => response.json())
    .then(users => {
        var buttonsDiv = document.getElementById('userButtons');

        users.forEach(function(user) {
            if (user.username == 'Other') {
                buttonsDiv.appendChild(document.createElement('br'));
                buttonsDiv.appendChild(document.createElement('br'));
            }
            var button = document.createElement('button');
            button.type = 'button';
            button.innerText = user.username;  // Use the 'username' property from your JSON objects
            button.onclick = function() {
                selectUser(user);
            };
            buttonsDiv.appendChild(button);
            buttonsDiv.appendChild(document.createElement('br'));
            buttonsDiv.appendChild(document.createElement('br'));
        });
    })
    .catch(error => console.error('Error:', error));
