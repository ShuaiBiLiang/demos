--创建数据库
create database my_db charset utf8;

--选择数据库
use my_db; 

--创建信息表
create table if not exists message(
	id int unsigned primary key auto_increment comment "用户ID",
	name varchar(20) default '匿名' comment "昵称",
	message varchar(500) not null comment "留言信息"
)charset utf8;

-- 新建一个字段
alter table message add `day` varchar(50) default null;

--查看信息表
desc student;
/*
+---------+-------------+------+-----+---------+-------+
| Field   | Type        | Null | Key | Default | Extra |
+---------+-------------+------+-----+---------+-------+
| name    | varchar(10) | YES  |     | NULL    |       |
| message | varchar(10) | YES  |     | NULL    |       |
+---------+-------------+------+-----+---------+-------+
2 rows in set
*/


--查看创建信息表的语句 
show create tables student;
/*
+---------+------------------------------------------------------------------------------------------------------------------------------------+
| Table   | Create Table                                                                                                                       |
+---------+------------------------------------------------------------------------------------------------------------------------------------+
| student | CREATE TABLE `student` (
  `name` varchar(10) DEFAULT NULL,
  `message` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 |
+---------+------------------------------------------------------------------------------------------------------------------------------------+
1 row in set
*/

--往信息表插入数据
insert into student(name,message,day) values('陈求求','这是测试的','2010-08-29 11:25:26');
--也可以这样写
insert into student values(null,'熊呆','这也是测试的','2010-08-29 11:25:26');

-- **************************这里是测试数据
insert into message values(null,'徐大大','测试卡拉头脑','2010-08-29 11:25:26');
insert into message values(null,'彭总','测试卡拉头脑','2010-08-29 11:25:26');
insert into message values(null,'周总','今天没作业','2010-08-29 11:25:26');
insert into message values(null,'老大','年终奖没了','2010-08-29 11:25:26');
insert into message values(null,'肥呆','奖励一百万','2010-08-29 11:25:26');
insert into message values(null,'大虫','今晚吃炸酱面','2010-08-29 11:25:26');
insert into message values(null,'老1','随便打1一下','2010-08-29 11:25:26');
insert into message values(null,'老2','随便打2一下','2010-08-29 11:25:26');
insert into message values(null,'老3','随便打3一下','2010-08-29 11:25:26');
insert into message values(null,'老4','随便打4一下','2010-08-29 11:25:26');
insert into message values(null,'老5','随便打5一下','2010-08-29 11:25:26');
insert into message values(null,'老6','随便打6一下','2010-08-29 11:25:26');	
insert into message values(null,'老7','随便打7一下','2010-08-29 11:25:26');
insert into message values(null,'老8','随便打8一下','2010-08-29 11:25:26');
insert into message values(null,'老9','随便打9一下','2010-08-29 11:25:26');
insert into message values(null,'老10','随便打10一下','2010-08-29 11:25:26');
insert into message values(null,'老11','随便打11一下','2010-08-29 11:25:26');
insert into message values(null,'老12','随便打12一下','2010-08-29 11:25:26');
insert into message values(null,'老13','随便打13一下','2010-08-29 11:25:26'); 

-- **************************这里是测试数据
/*

mysql> select * from student;
+----+--------+--------------+---------------------+
| id | name   | message      | day                 |
+----+--------+--------------+---------------------+
|  1 | 陈XX      | 这是测试的           | 2010-08-29 11:25:26 |
|  2 | 熊XX      | 这也是测试的          | 2010-08-29 11:25:26 |
|  3 | 徐大大       | 测试卡拉头脑           | 2010-08-29 11:25:26
|  4 | 彭总       | 测试卡拉头脑           | 2010-08-29 11:25:26 |
|  5 | 周总       | 今天没作业           | 2010-08-29 11:25:26 |
|  6 | 老大      | 年终奖没了           | 2010-08-29 11:25:26 |
|  7 | 肥呆      | 奖励一百万            | 2010-08-29 11:25:26 |
|  8 | 大虫       | 今晚吃炸酱面            | 2010-08-29 11:25:26
|  9 | 老1      | 随便打1一下           | 2010-08-29 11:25:26 |
| 10 | 老2      | 随便打2一下           | 2010-08-29 11:25:26 |
| 11 | 老3      | 随便打3一下           | 2010-08-29 11:25:26 |
| 12 | 老4      | 随便打4一下           | 2010-08-29 11:25:26 |
| 13 | 老5      | 随便打5一下           | 2010-08-29 11:25:26 |
| 14 | 老6      | 随便打6一下           | 2010-08-29 11:25:26 |
| 15 | 老7      | 随便打7一下           | 2010-08-29 11:25:26 |
| 16 | 老8      | 随便打8一下           | 2010-08-29 11:25:26 |
| 17 | 老9      | 随便打9一下           | 2010-08-29 11:25:26 |
| 18 | 老10     | 随便打10一下          | 2010-08-29 11:25:26 |
| 19 | 老11     | 随便打11一下          | 2010-08-29 11:25:26 |
| 20 | 老12     | 随便打12一下          | 2010-08-29 11:25:26 |
| 21 | 老13     | 随便打13一下          | 2010-08-29 11:25:26 |
+----+--------+--------------+---------------------+
21 rows in set (0.00 sec)
*/



--查询信息表
select * from student;
/*
+--------+--------------+
| name   | message      |
+--------+--------------+
| 陈XX | 这是测试的   |
| 熊XX   | 这也是测试的 |
+--------+--------------+
2 rows in set
*/

--查询数据总数
select count(*) from student;
/*
+----------+
| count(*) |
+----------+
|       14 |
+----------+
1 row in set
*/
 
 
--创建管理员表
create table if not exists admin(
	id int unsigned primary key auto_increment,
	userName varchar(20),
	userPassword varchar(20)
)charset utf8;

--增加管理用户
insert into admin(userName,userPassword) values('admin','admin');
insert into admin values(null,'test','feidai');



--向数据库查询用户名和密码
select count(*) from admin where userName='admin' and userPassword='admin';












































































