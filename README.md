# 📀 Antsy Bandcamp Catalog Builder

This is a minimal HTML parser used by [Antsy Records](https://antsy.seigr.net) to extract and publish its full Bandcamp catalog as a static `catalog.json`.

Although built specifically for **Antsy Records**, the approach can be reused by **any Bandcamp label** that needs to extract and serve its catalog independently — without APIs or headless browsers.

---

## ✅ What It Actually Does

- Parses a manually saved HTML file (`rendered_bandcamp.html`) of your Bandcamp label's `/music` page.
- Extracts:
  - Album title
  - Artist name
  - Album URL
  - Thumbnail URL
- Generates `catalog.json` — a machine-readable list of all public releases.
- Requires **no Bandcamp login**, **no API token**, and **no automation**.

---

## 📁 Files in This Repository

```bash
bandcamp_fetch_catalog.php       ← Parser script
bandcamp.php                     ← (Optional) Static JSON proxy for CORS/frontend use
README.md                        ← You're reading it
LICENSE                          ← MIT License
```

> Note: `catalog.json`, `rendered_bandcamp.html`, and `rendered_bandcamp_files/` are not stored in the repo but are generated/uploaded manually during use.

---

## 🧪 Example Output

```json
{
  "catalog": [
    {
      "title": "Quantum Fluctuation",
      "artist": "Sergi Saldaña-Massó",
      "url": "https://yourlabel.bandcamp.com/album/quantum-fluctuation",
      "thumbnail": "https://yourlabel.bandcamp.com/rendered_bandcamp_files/a1986858268_2.jpg"
    }
  ]
}
```

---

## 🛠 How to Use

### 1. Save Your Bandcamp Catalog Page

While logged into your Bandcamp label account:

1. Open: `https://yourlabel.bandcamp.com/music`
2. Right click → **Save Page As...** → select **Webpage, Complete**

This will create:

- `rendered_bandcamp.html`
- `rendered_bandcamp_files/` (folder with cover images)

### 2. Upload the Files

Upload those two items to the same directory as this script (`bandcamp_fetch_catalog.php`) on your server.

### 3. Run the Script

SSH into your server and run:

```bash
php bandcamp_fetch_catalog.php
```

This will create or update `catalog.json` in the same folder.

---

## 🌐 Serving the Data

You may serve `catalog.json` directly or use `bandcamp.php` as a wrapper:

```php
<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
readfile(__DIR__ . '/catalog.json');
?>
```

Frontend apps can then fetch your catalog from a CORS-safe endpoint like:

```
https://yourdomain.com/bandcamp.php
```

---

## 🤝 Intended Use

This tool was built by and for **Antsy Records** to support its own self-hosted frontend at [antsy.seigr.net](https://antsy.seigr.net).

However, the architecture is general enough that:

- Any Bandcamp label can adapt this workflow
- No credentials, APIs, or third-party services are required

---

## ❌ What This Is Not

- ❌ Not a headless browser or scraper
- ❌ Not connected to Bandcamp APIs
- ❌ Not a generic plugin or package
- ❌ Not dynamic or database-backed

This is **a static content preprocessor** designed for full control and future-proof access to your own label catalog.

---

## ⚖ License

MIT — free for anyone to reuse and adapt.\
No support is offered. Use at your own risk.

---

## 🧠 Maintainers

Built for internal use by **Antsy Records**\
Part of the modular tooling within the **Seigr Ecosystem**

