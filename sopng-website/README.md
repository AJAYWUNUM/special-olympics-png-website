# SOPNG Website

This project is a website for the Special Olympics Papua New Guinea (SOPNG), aimed at promoting awareness, fundraising, and marketing efforts for the organization.

## Project Structure

```
sopng-website
├── src
│   ├── index.html          # Main entry point of the website
│   ├── fundraising.html    # Fundraising page with donation options
│   ├── marketing.html      # Marketing page showcasing campaigns
│   ├── css
│   │   ├── style.css       # Main stylesheet for the website
│   │   ├── fundraising.css  # Styles specific to the fundraising page
│   │   └── marketing.css    # Styles specific to the marketing page
│   ├── js
│   │   ├── custom.js       # Main JavaScript file for the website
│   │   ├── fundraising.js   # Scripts specific to the fundraising page
│   │   └── marketing.js     # Scripts specific to the marketing page
│   ├── images
│   │   ├── fundraising
│   │   │   ├── fundraiser1.jpg  # Image for fundraising event 1
│   │   │   ├── fundraiser2.jpg  # Image for fundraising event 2
│   │   │   └── fundraiser3.jpg  # Image for fundraising event 3
│   │   ├── marketing
│   │   │   ├── campaign1.jpg     # Image for marketing campaign 1
│   │   │   ├── campaign2.jpg     # Image for marketing campaign 2
│   │   │   └── campaign3.jpg     # Image for marketing campaign 3
│   │   └── logo.png              # Logo image for the website
├── README.md                     # Documentation for the project
└── package.json                  # npm configuration file
```

## Setup Instructions

1. **Clone the Repository**
   ```bash
   git clone <repository-url>
   cd sopng-website
   ```

2. **Install Dependencies**
   Make sure you have Node.js installed. Then run:
   ```bash
   npm install
   ```

3. **Run the Project**
   You can use a local server to view the website. For example, you can use `live-server`:
   ```bash
   npx live-server src
   ```

## Features

- **Homepage**: The main entry point with links to fundraising and marketing pages.
- **Fundraising Page**: Information about fundraising efforts, including images and donation options.
- **Marketing Page**: Showcases marketing campaigns with relevant images and outreach information.

## Contributing

Contributions are welcome! Please feel free to submit a pull request or open an issue for any suggestions or improvements.

## License

This project is licensed under the MIT License. See the LICENSE file for details.