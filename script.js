document.addEventListener('DOMContentLoaded', function () {
    const statsForm = document.getElementById('statsForm');

    statsForm.addEventListener('submit', function (event) {
        event.preventDefault();

        // Gather form data
        const formData = new FormData(statsForm);

        // Convert FormData to JSON
        const jsonData = {};
        formData.forEach((value, key) => {
            jsonData[key] = value;
        });

        // For testing, log the JSON data
        console.log(jsonData);

        // Send data to the server
        fetch('submit_stats.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(jsonData),
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Success:', data);
                // Optionally, you can handle the response here
            })
            .catch((error) => {
                console.error('Error:', error);
                // Handle errors here
            });
    });
});
