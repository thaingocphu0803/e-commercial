Author: Thai Ngoc Phu

Contact: thaingocphu0803@gmail.com

------------

# I. Requirement

- Ubuntu 22.04 Server [Installation Guide](https://ubuntu.com/tutorials/install-ubuntu-server#1-overview)
- Docker [Installation Guide](https://docs.docker.com/engine/install/ubuntu/)

# II. Setting Up
##### Step 1: Clone the repository
```cmd
git clone https://github.com/thaingocphu0803/e-commercial.git
```

##### Step 2: Navigate to the project folder
```cmd
cd e-commercial
```

##### Step 3: Configure environment for Docker
- Rename **.env.example** to **.env**.
```cmd
mv .env.example .env
```

- Edit the **.env** file for Docker Compose.
```cmd
sudo vim .env
```

- Add or modify values according to the table below\:

| Name  | Description  |
| ------------ | ------------ |
|DB_ROOT_PASSWORD|Password for MySQL root user inside Docker|
|DB_NAME|Database name that will be created when MySQL container is initialized|

##### Step 4: Configure environment for Laravel app
- Go to the **src** folder.
```cmd
cd src
```
- Rename **.env.example** to **.env**.
```cmd
mv .env.example .env
```

- Edit the **.env** file for Docker Compose.
```cmd
sudo vim .env
```

- Add or modify values according to the table below\:
  
| Name  | Description  |
| ------------ | ------------ |
|DB_DATABASE|Same as **DB_NAME** defined in the root **.env**|
|DB_USERNAME|Usually **root**|
|DB_PASSWORD|Same as **DB_ROOT_PASSWORD** defined in the root **.env**|
|CLOUDINARY_URL|Cloudinary API key (see the [Get Cloudinary API Key](#1-get-cloudinary-api-key) section)|
|CLOUDINARY_UPLOAD_PRESET|Cloudinary upload preset (see the [Get Cloudinary Upload Preset](#3-get-cloudinary-upload-preset) section)|
|CLOUDINARY_NAME|Cloud name from your Cloudinary account (see the [Get Cloudinary Name](#2-get-cloudinary-cloud-name) section)|

##### Step 5: Set folder permissions
```cmd
sudo chmod -R 777 storage bootstrap/cache
```

##### Step 6: Go back to the root folder
```cmd
cd ../
```

##### Step 7: Build and start Docker containers
```cmd
sudo docker-compose up -d --build
```
##### Step 8: Import database data
Use the following command to import your SQL data into MySQL container. Replace **{db_password}** and **{db_name}** with the values defined in your root **.env**.
```cmd
sudo docker exec -i app_mysql mysql -u root -p{db_password} {db_name} < db/your_file.sql
```

##### Step 9: Install Composer dependencies
```cmd
sudo docker exec -it app_php_8.2 composer install
```

##### Step 10: Generate Laravel application key
```cmd
sudo docker exec -it app_php_8.2 php artisan key:generate
```

# III. Accessing the Application
After successfully starting the containers, open your browser and go to\:
| URL  | Description  |
| ------------ | ------------ |
|[localhost](http://localhost)|Main E-Commerce website|
|[localhost/admin](http://localhost/admin)|Admin Dashboard|

**Note**: Use the following credentials to log in to the admin panel\:
- Email: ```admin@gmail.com```.
- Password: ```111111```.

# IV. References
### 1. Get Cloudinary API Key
- Step 1: Log in to your [Cloudinary Console](https://cloudinary.com/users/login).
- Step 2: Navigate to **Settings** → **API Keys**.
- Step 3: Copy the API Environment Variable (starts with cloudinary://). Then, replace `<your_api_key>` and `<your_api_secret>` with your actual API Key and API Secret values.

### 2. Get Cloudinary Cloud Name
- Step 1: Log in to your [Cloudinary Console](https://cloudinary.com/users/login).
- Step 2: Go to the **Home** page.
- Step 3: In the Product Environment section, copy your Cloud Name.

### 3. Get Cloudinary Upload Preset
- Step 1: Log in to your [Cloudinary Console](https://cloudinary.com/users/login).
- Step 2: Go to **Settings** → **Upload**.
- Step 3: Click **Add Upload Preset**.
- Step 3: Enter necessary information and set **Signing Mode** to **Unsigned**.
- Step 3: Save, then copy the **Upload Preset Name** you just created.
