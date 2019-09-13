# Laravel Base Application

A json API with dynamic entity based endpoints.

## Features
  - Dynamic API
    - GET,POST,PUT,DELETE
    - Data Filtering
    - Pagination
    - Special End Points
      -SET,MATH,COPY
  - Multiple Format Rendering
    - JSON, XML, CSV
  - User Authentication
  - Docker via laradock

## Up and Running in Development

In project root directory

```
  composer update
```

Set the following variables in a .env file
```
APP_KEY=[Laravel API KEY]
DB_HOST=[YOUR DB HOST]
DB_USERNAME=[YOUR DB USERNAME]
DB_DATABASE=[YOUR DB DATABASE]
DB_PASSWORD=[YOUR DB PASSWORD]
REDIS_HOST=redis
QUEUE_HOST=beanstalkd
APP_DEBUG=true
```

Then
```
cd laradock
```
Next

```
cp env-example .env
```

Then
```
docker-compose up -d nginx mysql workspace
```

Finnally go to http://localhost and you should be up and running.


## Routes (End Points)

**entity** = The table name from the database you are querying.

### GET (READ)
- Endpoints
  - GET /api/{entity}
    - Example: /api/products   
  - GET /api/{entity}/{id?}
    - Example: /api/products/1
- Filters
  - limit: will add pagination to the response.
  - where[{field}]
    - Will filter based on criteria you set. 
    - Can have multiplie occurances in a single request.
    - Example : /api/customers/?where[name]=dave
  - orwhere[{field}]
    - Will filter based on criteria you set in addtion to the where filter.
    - Can have multiplie occurances in a single request.
    - Example : ?orwhere[name]=linda
  - fields
    - limit the response to only include specific fields
    - values are seperated by commas
    - Example : /api/customers?fields=id,name,email
  
  
### POST (CREATE)
  Used for creating 1 or more record in a database.
  - Endpoints  
    - POST /api/{entity}
      - data associated with entity models is submitted via a JSON array of objects or JSON single object in a POST request.
      
         ```
        Single Example :
        
        POST REQUEST:
        
        Endpoint : /api/customer
        data : {
          "name": "Dave",
          "email": "dave@test.com",
          }
          
        RESPONSE:
        {
          "status":"success",
          "event":"create_success",
          "entity":"customer",
          "data":{
            "id" : 1,
            "name": "Dave",
            "email": "dave@test.com",
          }
        }
        ```
      
         ```
        Multiple Create Example :
        
        POST REQUEST:
        
        Endpoint : /api/customer
        data : [
          {
          "name": "Dave",
          "email": "dave@test.com",
          },
          {
          "name": "Linda",
          "email": "linda@test.com",
          }
        ]
          
        RESPONSE: Will return IDs of the created entities
        {
          "status":"success",
          "event":"create_success",
          "entity":"customer",
          "data":{
            created:[1,2] 
          }
        }
        ```

### PUT (UPDATE)
 Used for updating 1 or more record in a database.
  - Endpoints  
    - PUT /api/{entity}/{id?} 
      - The id is optional, ids can also be included in the PUT request.
      - Multiple ids can be passed if they are seperated by commas.
      - data associated with entity models is submitted via a JSON array of objects or JSON single object in a PUT request.
      - id fields are required. 
      
         ```
        Single Example :
        
        PUT REQUEST:
        
        Endpoint : /api/customer
        data : {
          "id" : 1,
          "name": "David"
          }
          
        RESPONSE:
        {
          "status":"success",
          "event":"create_success",
          "entity":"customer",
          "data":{
            "id" : 1,
            "name": "David",
            "email": "dave@test.com",
          }
        }
        ```
      
         ```
        Multiple Create Example :
        
        PUT REQUEST:
        
        Endpoint : /api/customer
        data : [
          {
          "id": 1,
          "name": "David"
          },
          {
          "id": 2,
          "name": "Lin"
          }
        ]
          
        RESPONSE: Will return IDs of the created entities
        {
          "status":"success",
          "event":"create_success",
          "entity":"customer",
          "data":{
            updated:[1,2] 
          }
        }
        ```

#### SET
  Used to set individual fields to a specified values on 1 or many records. 
- Endpoints
  - GET /api/{entity}/set/{field}/{value}/{id}
  - PUT /api/{entity}/set/{field}/{value}/{id?}
  
- Examples:
  - GET /api/product/set/active/false/14
  - GET /api/product/set/price/30/14
  - GET /api/product/set/name/The+Wower/14
  
  -PUT

#### MATH
  Used to modify numeric field values by applying addition, subtraction, division, or multiplication math.  
- Endpoints
  - GET /{entity}/math/{field}/{math}/{id}
  - PUT /{entity}/math/{field}/{math}/{id?}

### DELETE
  Used to delete 1 or more records from the database. 
- Enpoints
  - DELETE /{entity}/{id?}

