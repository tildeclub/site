---
title: Adding a web counter to your page
author: deepend
category: tutorials
---

To display a visit counter on your webpage, you'll need to edit your `index.html` file and insert a `<script>` tag that loads the counter.

Type: `nano index.html` to open your file for editing.

Add the following line *exactly where you want the counter to appear*:

```html
<script src="https://counter.tilde.club/?page=homepage&user=yourname&style=57chevy"></script>
```

- Replace `homepage` with any identifier for the page you're tracking.
- Replace `yourname` with your username or something unique to your site.
- Replace `57chevy` with a different style if you'd like.

Here’s an example:

```html
<p>Visitor count:
<script src="https://counter.tilde.club/?page=homepage&user=alice&style=web1"></script>
</p>
```

Once you’ve added the line, save and close the file using `CTRL+X`, then press `y` and `[Enter]`.

Refresh your site in your browser to see the counter.

### Available Styles

You can use any of these style names in the `style=` parameter:

- `57chevy`
- `7seg`
- `bbldotg`
- `bellbtm`
- `blgrv`
- `cntdwn`
- `computer`
- `ds9`
- `fdb`
- `led`
- `links`
- `marsil`
- `sbgs`
- `web1`

Try different styles to see which one fits your site best.

Note: The counter uses sessions and cookies to count *unique* visits per user every 24 hours (or whatever time is configured). Page refreshes won’t increase the count unless unique mode is off.

If you need help or want a custom style added, reach out to the site admin.
```
