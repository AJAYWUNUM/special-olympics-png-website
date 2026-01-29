// JavaScript code for the marketing page

document.addEventListener('DOMContentLoaded', function() {
    // Function to display marketing campaigns
    function displayCampaigns() {
        const campaigns = [
            {
                title: "Campaign 1",
                image: "images/marketing/campaign1.jpg",
                description: "Join us in our first campaign to raise awareness about our programs."
            },
            {
                title: "Campaign 2",
                image: "images/marketing/campaign2.jpg",
                description: "Our second campaign focuses on community engagement and support."
            },
            {
                title: "Campaign 3",
                image: "images/marketing/campaign3.jpg",
                description: "Help us spread the word about our initiatives in the third campaign."
            }
        ];

        const campaignContainer = document.getElementById('campaigns');

        campaigns.forEach(campaign => {
            const campaignDiv = document.createElement('div');
            campaignDiv.classList.add('campaign');

            const campaignImage = document.createElement('img');
            campaignImage.src = campaign.image;
            campaignImage.alt = campaign.title;

            const campaignTitle = document.createElement('h3');
            campaignTitle.textContent = campaign.title;

            const campaignDescription = document.createElement('p');
            campaignDescription.textContent = campaign.description;

            campaignDiv.appendChild(campaignImage);
            campaignDiv.appendChild(campaignTitle);
            campaignDiv.appendChild(campaignDescription);
            campaignContainer.appendChild(campaignDiv);
        });
    }

    displayCampaigns();
});