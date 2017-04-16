# SlimApp RESTful API

This is a RESTful api built with the SlimPHP framework and uses MySQL for storage.

### Version
1.0.0

### Usage


### Installation

Copy sixhats folder to httpdocs(www)

Edit db/config params

Install SlimPHP and dependencies

```sh
$ composer
```
### API Endpints
```sh
$ GET /api/users
$ GET /api/user/{id}
$ POST /api/user/add
$ PUT /api/user/update/{id}
$ DELETE /api/user/delete/{id}

FOR WEB
//users
$ GET /api/users
$ GET /api/user/{id} --get user by id
$ POST /api/user/add --add user 
$ POST /api/user/update/{id} --update user
$ GET /api/user/delete/{id} --delete user

//sessions
$ GET /api/sesion
$ GET /api/sesion/{id} --get sesion by id
$ POST /api/sesion/add --add session 
$ POST /api/sesion/update/{id} --update sesion
$ GET /api/sesion/delete/{id} --delete sesion

//projects
$ GET /api/projects
$ GET /api/project/{id} --get project by id
$ POST /api/project/add --add project on client table 
$ POST /api/project/add/{user_id} --add project on server table 
$ POST /api/project/update/{id} --update project on client table
$ POST /api/project_server/update/{id}/{user_id} --update project on server table
$ GET /api/project/delete/{id} --delete project on client
$ GET /api/project_server/delete/{id} --delete project on server table

//ideas
$ GET /api/ideas
$ GET /api/idea/{id} --get sesion by id
$ POST /api/idea/add --add session 
$ POST /api/idea/update/{id} --update sesion
$ GET /api/idea/delete/{id} -- delete idea

//ideas
$ GET /api/categories -- get all categories
$ GET /api/category/{id} --get category by id
$ POST /api/category/add --add category 
$ POST /api/category/update/{id} --update category
$ GET /api/category/delete/{id} -- delete category



```
