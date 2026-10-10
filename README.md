# Special Olympics Papua New Guinea website

A responsive, multi-page website for Special Olympics Papua New Guinea. It includes separate pages for the five programs, events, donations, contact, volunteers and the merchandise marketplace. The home page has a rotating photo carousel, newsletter sign-up and a small page guide that helps visitors find the right section.

## Forms and database

Contact, Events, Marketplace and Donate enquiries are saved in the `website_enquiries` MySQL table. Newsletter sign-ups are saved in `newsletter_subscribers`; the newsletter form asks for consent, sends a welcome email to the subscriber, and includes an unsubscribe link. The website does not email enquiry details directly to the SOPNG inbox. SOPNG can view records in Hostinger's phpMyAdmin.

The package is ready for a Hostinger MySQL database, but it cannot connect until the database is created and the credentials are added. Before launch:

1. In Hostinger hPanel, create a MySQL database and user under **Databases → Management**. Keep the database name, user name and password private.
2. In phpMyAdmin, select that database and import `database-schema.sql`.
3. In Hostinger File Manager, edit `database-config.php` with the database details, the website's HTTPS address, and a sender email address hosted on your domain. Do not put real credentials into GitHub or share them in chat.
4. Configure Hostinger email sending for the sender address. The newsletter uses PHP `mail()`; if welcome messages do not arrive, set up authenticated SMTP for the site's domain mailbox.
5. Submit a contact enquiry and a newsletter subscription on the live HTTPS site. Confirm the two records appear in their database tables and the welcome email arrives.

Until these Hostinger settings are completed, forms report that the database is not connected. They do not silently discard submissions or claim an email was sent.

## Upload to Hostinger

Extract the ZIP and upload its contents to the domain's `public_html` folder so `index.html`, PHP files, `site.css`, `site.js` and the `assets` folder sit directly in `public_html`. Keep PHP enabled. Do not preview `index.html` from inside the ZIP; extract it or use the hosted website so styles, images and PHP handlers load.

## Content notes

- Marketplace listings show the supplied merchandise photos and collect questions; they do not set prices or process checkout.
- Event dates are not invented. Visitors are asked to contact SOPNG for current details.
- Volunteer names and roles should be added when the roster is confirmed.
- The page guide answers common navigation questions locally. It does not send visitors' questions to an AI service.
- The social links point to SOPNG's Facebook, Instagram and LinkedIn profiles.

