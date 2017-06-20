# 管理员表
create table bg_admin(
	admin_id tinyint unsigned primary key auto_increment,
	admin_name varchar(20) not null unique key,
	admin_pass char(32) not null,
	login_ip varchar(30) not null,
	login_nums int unsigned default 0,
	login_time int unsigned
);

insert into bg_admin values(null,'zhouyang',md5('12345678'),'127.0.0.1',0,unix_timestamp());



-- 在php2017中创建分类表
create table category(
	cate_id smallint unsigned primary key auto_increment,
	cate_name varchar(20) not null,
	cate_pid smallint not null -- 父类id号
);

-- 插入体验数据
insert into category values
	(1, '家用电器', 0),
	(2, '电视', 1),
	(3, '空调', 1),
	(4, '冰箱', 1),
	(5, '合资品牌', 2),
	(6, '国产品牌', 2),
	(7, '互联网品牌', 2),
	(8, '多门', 4),
	(9, '双门', 4),
	(10, '电脑', 0),
	(11, '电脑配件', 10),
	(12, '主板', 11),
	(13, '国产主板', 12),
	(14, '进口主板', 12);


-- 创建项目中的分类表
create table bg_category(
	cate_id smallint unsigned primary key auto_increment,
	cate_name varchar(20) not null,
	cate_pid smallint not null, -- 父类id号
	cate_sort smallint not null, -- 分类排序
	cate_desc varchar(255) -- 分类描述
);

-- 插入体验数据
insert into bg_category values
	(1, '慢生活', 0, 0, '慢生活有益健康'),
	(2, '日记', 1, 0, '慢生活有益健康'),
	(3, '欣赏', 1, 1, '请大家欣赏一下我的点点滴滴'),
	(4, '程序人生', 1, 2, '程序人生很苦逼'),
	(5, '经典语录', 1, 3, '哥的经典语录'),
	(6, 'PHP课堂', 0, 0, 'PHP课堂是有趣的'),
	(7, 'HTML', 6, 0, '基础班需要学习的第一个知识点');

-- 创建文章表
create table bg_article(
	art_id smallint unsigned primary key auto_increment,
	cate_id smallint unsigned not null comment '文章所属分类',
	title varchar(50) not null,
	thumb varchar(100) comment '缩略图',
	art_desc text,
	content text,
	author varchar(20),
	hits smallint unsigned not null default 100,
	addtime int unsigned not null comment '文章发表时间',
	is_del enum('0','1') not null default '0' comment '是否逻辑删除'
);

alter table bg_article 
	add is_recommend enum('0','1') not null default '0' after addtime;


-- 创建站长信息表
create table bg_master(
	id tinyint primary key auto_increment,
	nickname varchar(20) not null,
	job varchar(50) not null,
	home varchar(100) not null,
	tel char(11) not null,
	email varchar(100) not null
);

insert into bg_master values
	(null, '圣骑士 | 蜗牛的家','PHPer','四川|成都','13612345678','zhouyang@itcast.cn');

create table bg_singlePage(
	page_id tinyint unsigned primary key auto_increment,
	title varchar(50) not null,
	content text
);

insert into bg_singlePage values
	(null,'about us','我们来自传智播客广州校区PHP24期');

-- 创建用户表
create table bg_user(
	user_id smallint not null primary key auto_increment,
	user_name varchar(50),
	user_pass char(32),
	user_image varchar(100),
	user_time int unsigned comment '注册时间'
);

-- 创建评论表
create table bg_comment(
	cmt_id int unsigned primary key auto_increment,
	art_id smallint unsigned not null comment '被评论的文章的id号', 
	cmt_user varchar(20) not null,
	cmt_content text not null,
	cmt_time int unsigned not null
);