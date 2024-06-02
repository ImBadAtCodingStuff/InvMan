function selectUser(user) {
    if (user.username == 'Other') {
        confirm('this option is still in development. This option will show other users outside of OSP once i make it do that lol')
        window.location.href = 'index.html'
    } else {
        console.log(`Logging Inventory for user: ${user.username}`);
        localStorage.setItem('selectedUser', JSON.stringify(user));  // Store the user object in localStorage
        console.log("do we get to the invman.html window")
        window.location.href = "InvMan.html";
    }
}

//console.log("do we get to here?")

fetch('users.json')
    .then(response => response.json())
    .then(users => {
        var buttonsDiv = document.getElementById('userButtons');
        var otherButton = document.getElementById('otherButton');

        users.forEach(function(user) {
            if (user.username == 'Other') {
                otherButton.onclick = function() {
                    selectUser(user);
                };
            } else {
                var button = document.createElement('button');
                button.type = 'button';
                button.innerText = user.username;
                button.onclick = function() {
                    selectUser(user);
                };
                buttonsDiv.appendChild(button);
            }
        });
    })
    .catch(error => console.error('Error:', error));
