# Kcms

## Dependencies:
1. [linux]()
2. [apache2]()
3. [mysql5.7]()
4. [php5]()
5. [docker]() (optional)

> ####NOTE: 
> There is an *image* that already contains the dependencies and a populated Db. 
> - registry.gitlab.com/keijidev/kcms
> If the image is not used, the dependencies need to be manually installed. 
>
> *the sql backup can be used to populate the DB*

## Optional Configuration

### Apache Configuration:

- A copy of the Apache default .conf file at: /etc/apache2/apache2.backup.conf
- Changes to the Apache /etc/apache2/apache2.conf file are:
    - "KeepAlive Off" instead of on
    - Module added to end of file: StartServers 2 MinSpareServers 6 MaxSpareServers 12 MaxClients 30 MaxRequestsPerChild 3000
    - Hostname added to end of file: ServerName localhost
    - Enabled Virtual Host file at /etc/apache2/sites-available/example.com.conf
    - Created directories for Virtual Host file:
        - /var/www/example.com /var/www/example.com/public_html 
        - /var/www/example.com/log /var/www/example.com/backups

### MySQL Configuration:

- Temporary root password: `Admin2015` 
    - It is recommended to change on first run
- Ran mysql_secure_installation: 
    - Removed anonymous user accounts
    - Disable remote root login 
    - Removed the test database
- MySQL configuration file at /etc/mysql/my.cnf i. Changed settings:
    ```xml
        max_connections = 75
        key_buffer = 32M
        max_allowed_packet = 1M
        thread_stack = 128K
        table_cache = 32
    ```
- Example database: `kcms`
- Example user: `root`
- Example user password: `Admin2015`

### PHP Configuration:

- PHP configuration file at /etc/php5/apache2/php.ini
    - Changed settings: 
        > max_execution_time = 30 memory_limit = 128M error_reporting = E_COMPILE_ERROR|E_RECOVERABLE_ERROR|E_ERROR|E_CORE_ERROR display_errors = Off log_errors = On error_log = /var/log/php/error.log register_globals = Off
- Created directory: /var/log/php
- Changed /var/log/php ownership to www-data

## Run

- Clone the repository
- Run the image from gitlab/registry
    ```bash
    docker run --name kcms -it -v "$PWD:/var/www/example.com/public_html" -p 80:80 registry.gitlab.com/keijidev/kcms /bin/bash
    ```
- Manually start apache and mysql within the container
    ```bash
    service apache2 start
    ```
    ```bash
    service mysql start
    ```
- Exit the container by pressing: `ctrl + p` and `ctrl + q`
- Navigate to `https://localhost/`

> ####Note
> The website’s root directory is /var/www/example.com/public_html/.

