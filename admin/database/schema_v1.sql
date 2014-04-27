create table adminusers (
                adminUsersId int unsigned not null auto_increment primary key,
                email varchar(255) not null,
                password varchar(255) not null,
                created datetime not null,
                lastUpdated timestamp not null on update current_timestamp
            ) engine InnoDB;

insert into adminusers (email, password, created) values ('jonforest@gmail.com', 'abc123.', now());

create table categories (
                categoryId int unsigned not null auto_increment primary key,
                name varchar(255) not null,
                heroText text not null,
                details text,
                sizingHtml text null,
                status tinyint not null default 1,
                created datetime not null,
                lastUpdated timestamp not null on update current_timestamp
            )  engine InnoDB;

insert into categories (name, heroText, created) values
            ('Eyewear', '<div>The complete <span class="stand-out">eyewear</span> solution</div><div class="subText">Eye protection for clinicians and patients.</div>', now()),
            ('Gonad Shield', '<div>The complete <span class="stand-out">gonad shield</span> solution</div><div class="subText">Protection where it is really needed.<br>Light weight protection for reproductive organs.</div>', now()),
            ('Hand Protection', '<div>The complete <span class="stand-out">hand protection</span> solution</div><div class="subText">Disposable gloves that provide the highest possible, Lead free, protection.</div>', now()),
            ('Head and Patient Shield', '<div>The complete <span class="stand-out">head and patient</span> solution</div><div class="subText">Protection where it is needed most.<br>Designed for Cardiology, Radiology and Dentistry.</div>', now()),
            ('Thyroid Shield', '<div>The complete <span class="stand-out">thyroid shield</span> solution</div><div class="subText">Complete protection to neck and sternum.<br>Cardiology, Radiology and Dentistry applications.</div>', now()),
            ('Ultra Apron', '<div>The complete <span class="stand-out">apron</span> solution</div><div class="subText">Ergonomic, durable and light weight.</div>', now());

create table products (
                productId int unsigned not null auto_increment primary key,
                categoryId int unsigned null,
                price  decimal(8,2) not null,
                name text,
                sequence int unsigned default 1,
                status tinyint not null default 1,
                created datetime not null,
                lastUpdated timestamp not null on update current_timestamp,
                foreign key FK_products_categories (categoryId) references categories(categoryId) on delete set null
            )  engine InnoDB;

create table productdetailitems (
                productDetailItemId int unsigned not null auto_increment primary key,
                productId int unsigned not null,
                description text,
                status tinyint not null default 1,
                created datetime not null,
                lastUpdated timestamp not null on update current_timestamp,
                foreign key FK_productsdetailsitems_product (productId) references products(productId) on delete cascade
            )  engine InnoDB;

create table images (
                imageId int unsigned not null auto_increment primary key,
                productId int unsigned not null,
                imagePath varchar(255),
                imageTitle varchar(100),
                caption text,
                status tinyint not null default 1,
                created datetime not null,
                lastUpdated timestamp not null on update current_timestamp
            ) engine InnoDB;

create table content (
  contentId int unsigned not null auto_increment primary key,
  pageId int unsigned not null,
  html text,
  status tinyint not null default 1,
  created datetime not null,
  lastUpdated timestamp not null on update current_timestamp
) engine InnoDB;

create table pages (
  pageId int unsigned not null auto_increment primary key,
  title varchar(200),
  reference varchar(100),
  heroText text,
  status tinyint not null default 1,
  created datetime not null,
  lastUpdated timestamp not null on update current_timestamp
) engine InnoDB;

insert into pages (title, reference, created) values ('Contact Us', 'contact', now()),
('Returns Policy', 'returns', now()), ('About Us', 'about', now()), ('Company Info / Legal', 'legal', now());

create table prices (
  priceId int unsigned not null auto_increment primary key,
  productId int unsigned not null,
  price float,
  priceDiscriminator varchar(500),
  priceFrom tinyint(1) null default 0,
  priceOnRequest tinyint not null default 0,
  status tinyint not null default 1,
  created datetime not null,
  lastupdated timestamp not null on update current_timestamp
) engine InnoDB


create table categorydetailitems (
    categoryDetailItemId int unsigned not null auto_increment primary key,
    categoryId int unsigned not null,
    description text,
    status tinyint not null default 1,
    created datetime not null,
    lastUpdated timestamp not null on update current_timestamp,
    foreign key FK_categorydetailsitems_categories (categoryId) references categories(categoryId) on delete cascade
)  engine InnoDB;


create table statuses (
  statusId tinyint unsigned not null primary key,
  description varchar(200) not null,
  created datetime not null,
  lastupdated timestamp not null on update current_timestamp
) engine InnoDB;