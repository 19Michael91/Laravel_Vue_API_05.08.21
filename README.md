
## Backend launch

To start the server side of the application, you need to open a terminal, go to the Backend folder and follow these steps:

- composer install
- Create a database
- Create a database user
- In root folder create .env file
- Connect applications to the database in the .env file
- php artisan migrate
- php artisan passport:install
- php artisan db:seed --class=OrganisationSeeder
- To receive a letter after the organization is created, set the following environment variables in the .env file:

	- MAIL_MAILER
	- MAIL_HOST
	- MAIL_PORT
	- MAIL_USERNAME
	- MAIL_PASSWORD
	- MAIL_ENCRYPTION
	- MAIL_FROM_ADDRESS
	- MAIL_FROM_NAME


## Frontend launch

To start the client side of the application, you need to open a terminal, go to the Frontend folder and follow these steps:

- npm instal
- npm run dev
- Go to localhsot:8080
- to set the address of the server to which requests will be sent, you need to set the string value of the serverURL field in the configuration object of the /src/config.js file

After following the instructions to test the application, the user will appear in the database:

 - email: "test@test.com"
 - password: "password"