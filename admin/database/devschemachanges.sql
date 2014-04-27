/* 02/03/14 */
alter table products
  add column sequence int unsigned default 1 after name;

insert into prices (productId, price, created) select productId, price, now() from products p where p.status=1;

UPDATE `categories` SET `name` = 'Eyewear',`heroText` = '<div>The complete <span class="stand-out">eyewear</span> solution</div><div class="subText">Eye protection for clinicians and patients.</div>',`status` = 1,`created` = '2014-03-03 05:53:09',`lastUpdated` = '0000-00-00 00:00:00' WHERE `categories`.`categoryId` = 1;
UPDATE `categories` SET `name` = 'Gonad Shield',`heroText` = '<div>The complete <span class="stand-out">gonad shield</span> solution</div><div class="subText">Protection where it is really needed.<br>Light weight protection for reproductive organs.</div>',`status` = 1,`created` = '2014-03-03 05:53:09',`lastUpdated` = '0000-00-00 00:00:00' WHERE `categories`.`categoryId` = 2;
UPDATE `categories` SET `name` = 'Hand Protection',`heroText` = '<div>The complete <span class="stand-out">hand protection</span> solution</div><div class="subText">Disposable gloves that provide the highest possible, Lead free, protection.</div>',`status` = 1,`created` = '2014-03-03 05:53:09',`lastUpdated` = '0000-00-00 00:00:00' WHERE `categories`.`categoryId` = 3;
UPDATE `categories` SET `name` = 'Head and Patient Shield',`heroText` = '<div>The complete <span class="stand-out">head and patient</span> solution</div><div class="subText">Protection where it is needed most.<br>Designed for Cardiology, Radiology and Dentistry.</div>',`status` = 1,`created` = '2014-03-03 05:53:09',`lastUpdated` = '0000-00-00 00:00:00' WHERE `categories`.`categoryId` = 4;
UPDATE `categories` SET `name` = 'Thyroid Shield',`heroText` = '<div>The complete <span class="stand-out">thyroid shield</span> solution</div><div class="subText">Complete protection to neck and sternum.<br>Cardiology, Radiology and Dentistry applications.</div>',`status` = 1,`created` = '2014-03-03 05:53:09',`lastUpdated` = '0000-00-00 00:00:00' WHERE `categories`.`categoryId` = 5;
UPDATE `categories` SET `name` = 'Ultra Apron',`heroText` = '<div>The complete <span class="stand-out">apron</span> solution</div><div class="subText">Ergonomic, durable and light weight.</div>',`status` = 1,`created` = '2014-03-03 05:53:09',`lastUpdated` = '0000-00-00 00:00:00' WHERE `categories`.`categoryId` = 6;

alter table categories
  add column details text after heroText;

alter table categories add column sizingHtml text null after details;

alter table pages add column heroText text null after reference;

insert into statuses (statusId, description, created) VALUES
  (0, 'deleted', now()),
  (1, 'enabled', now()),
  (2, 'disabled', now()),
  (3, 'footer only', now()),
  (4, 'header only', now())

update pages set status=2 where title = 'About Us';