# Laravel simple API

This is an example of a simple API for users CRUD.

## Installation

1. Clone this repository to your local machine.
2. Execute docker compose command in the repo folder: `docker-compose up -d `

## License

This project is licensed under the [MIT License](LICENSE).


# API Documentation

## Create User

- Endpoint: `/users`
- Method: `POST`

Request:
```
curl -X POST -H "Content-Type: application/json" -d '{
  "name": "John Doe",
  "email": "johndoe@example.com",
  "password": "secretpassword"
}' http://localhost:8080/api/users
```

Response: JSON object representing the created user.

## Generate Access Token for Authentication

- Endpoint: `/auth`
- Method: `POST`
- URL Parameters: - `email` (string, required) - The email of the user. `password` (string, required) - The password of the user.

Request:
```
curl -X POST -H "Content-Type: application/json" -d '{
  "email": "johndoe@example.com",
  "password": "secretpassword"
}' http://localhost:8080/api/auth
```

Response: JSON object with the generated access token.

## Retrieve All Users

- Endpoint: `/users`
- Method: `GET`
- Authentication: Requires authentication (using Sanctum)

Request:
```
curl -X GET -H "Authorization: Bearer {access_token}" http://localhost:8080/api/users
```

Response: JSON array of users.

## Get Single User

- Endpoint: `/users/{id}`
- Method: `GET`
- Authentication: Requires authentication (using Sanctum)
- URL Parameters: `id` (integer, required) - The ID of the user to retrieve.

Request:
```
curl -X GET -H "Authorization: Bearer {access_token}" http://localhost:8080/api/users/{id}
```
Response: JSON object representing the user.

## Update User

- Endpoint: `/users/{id}`
- Method: `PUT`
- Authentication: Requires authentication (using Sanctum)
- URL Parameters: `id` (integer, required) - The ID of the user to update.

Request:
```
curl -X PUT -H "Authorization: Bearer {access_token}" -H "Content-Type: application/json" -d '{
  "name": "John Smith",
  "email": "johnsmith@example.com"
}' http://localhost:8080/api/users/{id}
```

Response: JSON object representing the updated user.

## Delete User

- Endpoint: `/users/{id}`
- Method: `DELETE`
- Authentication: Requires authentication (using Sanctum)
- URL Parameters: `id` (integer, required) - The ID of the user to delete.

Request:
```
curl -X DELETE -H "Authorization: Bearer {access_token}" http://localhost:8080/api/users/{id}
```


Response: JSON object indicating success.
