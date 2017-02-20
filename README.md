# IIP Test task
## 1-st

#### Create user:
![](http://dl4.joxi.net/drive/2017/02/20/0004/1376/279904/04/76274b0f3a.jpg)
or
![](http://dl4.joxi.net/drive/2017/02/20/0004/1376/279904/04/eb3b9965f4.jpg)
(becouse role with name BLABLABLS not exist)
Request: POST

```json
{
	"username":"Sergey Trizna",
	"email": "init.reg@gmail.com",
	"age": "26",
	"role":"ADMIN"
} 
```
Response:
```json
{
  "status": "ok",
  "data": "Md2leQys"
}
```
where "data" contain passwortd for created user;

#### Auth:
![](http://dl4.joxi.net/drive/2017/02/20/0004/1376/279904/04/291ba666cc.jpg)
or
![](http://dl4.joxi.net/drive/2017/02/20/0004/1376/279904/04/ea87c0e9a5.jpg)
Request: POST

```json
{
	"email":"init.reg@gmail.com",
	"password":"Md2leQys"
} 
```

#### Auth:
![](http://dl4.joxi.net/drive/2017/02/20/0004/1376/279904/04/291ba666cc.jpg)
or
![](http://dl4.joxi.net/drive/2017/02/20/0004/1376/279904/04/ea87c0e9a5.jpg)
Request: POST

```json
{
	"email":"init.reg@gmail.com",
	"password":"Md2leQys"
} 
```

#### Edit: 
![](http://dl3.joxi.net/drive/2017/02/20/0004/1376/279904/04/ba4a0f91c2.jpg)
Request: POST
```json
{
	"username":"Sergey T",
	"email": "init.reg@mail.ru",
	"age": "99",
} 
```

#### Delete: 
![](http://dl4.joxi.net/drive/2017/02/20/0004/1376/279904/04/eaf5abefbe.jpg)


#### Verifying of rights
  1. Login as SUPER_ADMIN
```json
{
	"email":"root@root.dev",
	"password":"8mmNJYLn"
} 
```
![](http://dl3.joxi.net/drive/2017/02/20/0004/1376/279904/04/373189e119.jpg)

2. Trying create user with role SUPER_ADMIN
```json
{
	"username":"New User",
	"email": "nu@nu.dev",
	"age": "26",
	"role":"SUPER_ADMIN"
}
```
![](http://dl4.joxi.net/drive/2017/02/20/0004/1376/279904/04/eed0064e97.jpg)

3. Trying create user with role ADMIN
```json
{
	"username":"New User",
	"email": "nu@nu.dev",
	"age": "26",
	"role":"ADMIN"
}
```
![](http://dl4.joxi.net/drive/2017/02/20/0004/1376/279904/04/0e5a8e8a61.jpg)


## 2-nd
#### Structure: 
```sql
CREATE TABLE IF NOT EXISTS `tree` (
  `node_id` int(11) unsigned NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT INTO `tree` (`node_id`, `parent_id`, `title`) VALUES
(1, NULL, 'Node1'),
(2, 1, 'Node2'),
(3, 2, 'Node3'),
(4, 2, 'Node4'),
(5, NULL, 'Node5');

ALTER TABLE `tree`
  ADD PRIMARY KEY (`node_id`);
```
#### Result: 
![](http://dl3.joxi.net/drive/2017/02/20/0004/1376/279904/04/e6115f572d.jpg)

## 3-th
#### Structure: 
```sql
CREATE TABLE IF NOT EXISTS `ticks` (
  `id` int(11) NOT NULL,
  `symbol` varchar(6) NOT NULL,
  `date` date NOT NULL,
  `value` decimal(11,2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

INSERT INTO `ticks` (`id`, `symbol`, `date`, `value`) VALUES
(1, 'EURUSD', '2014-01-10', '1.34'),
(2, 'GBPUSD', '2014-01-10', '1.67'),
(3, 'EURUSD', '2014-01-09', '1.31'),
(4, 'NZDUSD', '2014-01-09', '0.83');
```

#### Request:
```sql
SELECT *
FROM ticks t1
WHERE t1.date = (SELECT MAX(t2.date)
                 FROM ticks t2
                WHERE t1.symbol = t2.symbol
                ) 
```

#### Result: 
![](http://dl3.joxi.net/drive/2017/02/20/0004/1376/279904/04/51320750b6.jpg)

