# ToDo app API

The ToDo app API is a simple API interface for managing tasks. It allows creating, updating, displaying, and deleting tasks.

## Getting Started

The instructions below will help you get a copy of the project up and running on your local machine for development and testing purposes.

### Initialization

To initialize the application, run the following command:

```bash
npm run init-app
```

## Configuration

Fill the .env file with your database credentials:

```DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```
Similarly, fill the .env.testing file with database credentials for testing:

```DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```
Testing the Application
To test the application, use the following command:

```bash
npm run test
```
## Running the Application
To run the application, use the following command:

```bash
npm run serve
```
Once started, the API is available and ready for use.

## API Documentation
You can check the API documentation by visiting:

```http://localhost:8000/api/documentation```

This documentation includes detailed information about the available endpoints, their parameters, and example responses.
