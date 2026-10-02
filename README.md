# Special Olympics Papua New Guinea website

A new responsive, multi-page website inspired by the clear programs, impact and story structure of [Special Olympics Bharat](https://specialolympicsbharat.org/), with SOPNG's own identity and copy.

## Pages

- Home page with an accessible, automatically sliding image carousel.
- About SOPNG and Programs overview.
- A separate page for Sports & Competition, Young Athletes, Family Support Network, Healthy Communities and Youth Innovation.
- A Volunteers & Leadership page with the supplied 25 volunteer portraits. Name and position fields are placeholders for the roster details SOPNG will add later.
- Events, Donate and Contact pages.

The All pages menu links to every page above. Athlete profiles are kept separate from the volunteer directory. Each editorial photograph is used on only one page. The organization logo and favicon are shared identity assets.

Older page URLs redirect to their matching new page so bookmarks and links still resolve.

## Contact forms

The Contact, Events and Donate pages have forms. The forms submit to `contact.php`, which validates the fields and emails the enquiry to `info@specialolympicspapuanewguinea.org`. The receiving inbox was supplied by SOPNG for this site. Enquiries are not saved in a website database.

The form handler uses PHP's `mail()` function. Hostinger must have outbound PHP email enabled for the messages to be delivered. If Hostinger does not deliver the messages, configure the account's recommended SMTP mailer before launch.

## Hostinger upload

1. Extract the ZIP on your computer.
2. In Hostinger File Manager, open the domain's `public_html` folder.
3. Upload the *contents* of the extracted website folder so `index.html`, `contact.php`, `site.css`, `site.js` and `assets` sit directly in `public_html`.
4. Keep PHP enabled on the hosting plan so the forms can submit.
5. Open the live domain, check the pages and submit a real test enquiry to confirm Hostinger can send mail to the team inbox.

Do not preview the site by opening `index.html` from inside the ZIP. Extract it first or preview it on the hosted domain so the browser can find the styles, images and PHP form handler.

## Maintenance notes

- Update `form-config.php` if SOPNG changes the contact inbox.
- Update the placeholder names and positions in `volunteers.html` when the volunteer roster is ready.
- The Events page deliberately asks visitors to contact SOPNG for current event dates; no calendar or event schedule was supplied for this redesign.
- The Donate page collects enquiries only. It does not collect payment details or process donations online.
