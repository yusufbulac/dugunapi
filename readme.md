## Dugun Apı
* GET
`/products`

Response success status code : 200

| query parameters | description |
| ---------------- | ------------ |
| name       | search by name |
| status     | search by status |
| startPrice | search by start price and for equal price |
| endPrice   | search by end price and for equal price|
| startDate  | search by start created date |
| endDate    | search by end created date |

sample usage
    `/products?startPrice=10000&endPrice=17000&status=active`
-----
* POST
  `/products`

Response success status code : 200

| request body |  |
| ---------------- | ------------ |
| name       | required |
| status     | required |
| price     | required |
-----
* PUT
  `/products/{id}`

Response success status code : 201

| request body |  |
| ---------------- | ------------ |
| name       | required |
| status     | required |
| price     | required |
-----
* DELETE
  `/products/{id}`

Response success status code : 204
