# README #

## Local Development ##

### Database ###

You can download a copy of the production database from cPanel. Credentials for cPanel are in vault under __Maryland Food Bank Cpanel__

### wp-config.php ###

You will need to create a `wp-config.php` file with local database connection info.

### Uploads ###

You can reference the production uploads folder (so you don't have to download the uploads folder locally) by browsing to <local-site-url>/wp-admin/options.php, and adding a value of `http://mdfoodbank.org/wp-content/uploads` for the `upload_url_path`.