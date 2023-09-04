# Geocities-inspired Guestbook

A modern take on the classic Geocities guestbook, built with PHP and SQLite. This guestbook allows for multi-user functionality, user-specific themes, and adheres to current coding standards.

## Features

- **Multi-user Support**: Each user can have their own guestbook by simply accessing [https://tilde.club/guestbook/?user=username](https://tilde.club/guestbook/?user=username).
- **Custom Themes**: Users can specify their own CSS theme by placing a `.css` file in their directory and specifying it with the `theme` parameter in the URL.
- **Referrer Validation**: The guestbook checks the referrer to ensure that entries are being made from the correct user's page.
- **SQLite Backend**: Uses SQLite for a lightweight and serverless database solution.

## Customization

### Themes

Users can specify their own theme by placing a `.css` file in their directory. This theme can be applied by adding the `theme` parameter to the URL, e.g., [https://tilde.club/guestbook/?user=username&theme=cssname](https://tilde.club/guestbook/?user=username&theme=cssname).

A default `dark.css` theme is provided in the repository as an example.

### Adding Entries

User need to link to the guestbook from their tilde page to https://tilde.club/guestbook/?user=username  or 
https://tilde.club/guestbook/?user=username&theme=themecssname and then your viewers can
simply fill out the form on your guestbook page and submit.
