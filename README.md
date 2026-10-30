# hobrtEcom
hobrt eCommerce script

## Requirements

- PHP 8.1 or newer with the `pdo_mysql`, `gd`, `intl`, `curl` and `mbstring` extensions
- MySQL 5.7+ or MariaDB 10.2+
- Apache with `mod_rewrite` (the `.htaccess` files also protect private files), or nginx with the rules from `nginx.conf.example`

## Install a new store

1. Create an empty database and a database user in your hosting panel.
2. Download the ZIP of the [latest release](https://github.com/hobrt-programming/hobrtEcom/releases/latest): it already contains `application/vendor`. From a git clone instead, run `composer install` inside the `application` folder.
3. Upload all files to your web root or to a sub folder.
4. Open `yourdomain.com/install/install.php` (any page of the store redirects there until it is installed).
5. Fix anything the requirements list shows in red. The folders `application/config`, `application/cache`, `application/logs`, `uploads` and `images` must be writable by PHP (755 is usually enough, never use 777).
6. Choose **New store**, fill in the database, store and admin account, then click install.

The installer writes `application/config/local.php` (database and store URL) and `application/config/secrets.php`. Keep them private and back them up. Once they exist the installer locks itself; you can delete the `install` folder for extra safety.

### Template editor and AI assistant (optional)

Admin > Themes > Template editor and its AI assistant save changes to the store theme files, so PHP needs write access to **`themes/front` only**. Leave everything else (`application`, `system`, `themes/enAdmin`) read-only. Theme `.php` files can't be opened by URL (`themes/.htaccess`, or the `themes` rule in `nginx.conf.example`), so a writable theme file is still only run by the store itself.

- **Shared hosting** (PHP runs as your hosting user): usually nothing to do.
- **Your own server** (PHP runs as `nginx`, `apache` or `www-data`): give that user write access to the folder, for example on Fedora/RHEL with SELinux:

  ```bash
  sudo setfacl -R -m u:nginx:rwX -m d:u:nginx:rwX themes/front
  sudo semanage fcontext -a -t httpd_sys_rw_content_t "$PWD/themes/front(/.*)?"
  sudo restorecon -Rv themes/front
  ```

If you don't use the editor, skip this: the store works with read-only themes.

### Hidden admin login (optional)

In Admin > Store Settings > Admin login address you can choose a secret address for the login page (for example `yourdomain.com/office-3f9a2c71`). Once set, the login form is only there: `user/admin_login` and every admin page answer "page not found" to anyone not logged in. After signing in, the admin works as usual with its normal `/admin/...` links. Bookmark the address.

**Lost it?** Open your database (phpMyAdmin) and run `DELETE FROM hb_meta WHERE k = 'admin_path';`. `/admin` works again right away.

### Errors and development mode

Live stores never show PHP errors to visitors; errors are written to `application/logs` instead. To see errors while developing, set the `CI_ENV` environment variable to `development`: `SetEnv CI_ENV development` in `.htaccess` (Apache) or `fastcgi_param CI_ENV development;` in the PHP location (nginx).

## Upgrade an existing store

**Back up your database and your `uploads`/`images` folders first.**

### From the 2019 or 2023 release

1. Upload the files of the new release over the old ones.
2. Open `yourdomain.com/install/install.php` and choose **Upgrade an existing store**.
3. Enter the database details of your store and your current admin username and password.

The upgrade keeps all your data: it adds the missing tables and columns, converts old orders, dates and reviews, creates the URL slugs for products and categories, and your old admin password keeps working.

After the upgrade:
- SMS notifications need your own Hbsms token and device id in **Admin > Settings**.
- Check the store URL in **Admin > Settings** and your theme.

### Future releases

Upload the new files. When the database needs changes, the admin panel shows a banner: click **Update now** (or open `install/install.php` and log in with an admin account).

## Development

Copy your settings into `application/config/local.php` (see the installer output for the format) or use the `HBECOM_DB_HOST`, `HBECOM_DB_PORT`, `HBECOM_DB_NAME`, `HBECOM_DB_USER`, `HBECOM_DB_PASS` and `HBECOM_BASE_URL` environment variables. Set `CI_ENV=development` to display errors.
