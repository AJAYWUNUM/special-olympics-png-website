// JavaScript code for the fundraising page
document.addEventListener("DOMContentLoaded", function() {
    const donateButton = document.getElementById("donate-button");
    const messageContainer = document.getElementById("message-container");

    donateButton.addEventListener("click", function() {
        messageContainer.innerHTML = "<p>Thank you for your generous donation!</p>";
        messageContainer.style.display = "block";
    });

    // Function to display fundraising events
    function displayFundraisingEvents() {
        const events = [
            {
                title: "Annual Charity Run",
                date: "March 15, 2023",
                image: "images/fundraising/fundraiser1.jpg"
            },
            {
                title: "Community Bake Sale",
                date: "April 20, 2023",
                image: "images/fundraising/fundraiser2.jpg"
            },
            {
                title: "Charity Gala Night",
                date: "May 30, 2023",
                image: "images/fundraising/fundraiser3.jpg"
            }
        ];

        const eventsContainer = document.getElementById("events-container");
        events.forEach(event => {
            const eventElement = document.createElement("div");
            eventElement.classList.add("event");
            eventElement.innerHTML = `
                <h3>${event.title}</h3>
                <p>Date: ${event.date}</p>
                <img src="${event.image}" alt="${event.title}" class="event-image">
            `;
            eventsContainer.appendChild(eventElement);
        });
    }

    displayFundraisingEvents();
});