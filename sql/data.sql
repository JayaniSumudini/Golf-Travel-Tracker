INSERT INTO user_details
(user_id,user_email,password)
VALUES
  (1,'test1@gmail.com','test1'),
  (2,'msjs.sumudini@gmail.com','test2'),
  (3,'test3@gmail.com','test3'),
  (4,'test4@gmail.com','test4'),
  (5,'test5@gmail.com','test5'),
  (6,'test6@gmail.com','test6'),
  (7,'test7@gmail.com','test7'),
  (8,'test8@gmail.com','test8'),
  (9,'test9@gmail.com','test9');


INSERT INTO party_details
  (party_id,lead_name,phone_number,email,hotel_address,flight_number,notes,user_id,number_in_party,create_date_and_time)
VALUES
  (1,'test1',1234567,'test1@gmail.com','test1,road,street,city','CDUW3445','abcdefghijklmnopqrstuvwxyz', 1,12,NOW()),
  (2,'test2',1234567,'test2@gmail.com','test2,road,street,city','CDUW3445','abcdefghijklmnopqrstuvwxyz', 1,10,NOW()),
  (3,'test3',1234567,'test3@gmail.com','test3,road,street,city','CDUW3445','abcdefghijklmnopqrstuvwxyz', 1,15,NOW()),
  (4,'test4',1234567,'test4@gmail.com','test4,road,street,city','CDUW3445','abcdefghijklmnopqrstuvwxyz', 2,14,NOW()),
  (5,'test5',1234567,'test5@gmail.com','test5,road,street,city','CDUW3445','abcdefghijklmnopqrstuvwxyz', 2,149,NOW()),
  (6,'test6',1234567,'test6@gmail.com','test6,road,street,city','CDUW3445','abcdefghijklmnopqrstuvwxyz', 2,245,NOW()),
  (7,'test7',1234567,'test7@gmail.com','test7,road,street,city','CDUW3445','abcdefghijklmnopqrstuvwxyz', 3,231,NOW()),
  (8,'test8',1234567,'test8@gmail.com','test8,road,street,city','CDUW3445','abcdefghijklmnopqrstuvwxyz', 3,45,NOW()),
  (9,'test9',1234567,'test9@gmail.com','test9,road,street,city','CDUW3445','abcdefghijklmnopqrstuvwxyz', 3,4,NOW()),
  (10,'test10',1234567,'test10@gmail.com','test10,road,street,city','CDUW3445','abcdefghijklmnopqrstuvwxyz', 3,623,NOW());


INSERT INTO itenary
  (itenary_id,party_id,status,total_price)
VALUES
  (1,1,'NEW',120),
  (2,2,'NEW',60),
  (3,3,'SUBMITED',1450),
  (4,4,'SUBMITED',80),
  (5,5,'SAVE',20),
  (6,6,'NEW',90),
  (7,7,'ACCEPTED',150),
  (8,8,'ACCEPTED',500),
  (9,9,'SUBMITED',290),
  (10,10,'ADMIN_CHANGED',420);


INSERT INTO trip
  (trip_id,travel_date,travel_time,travel_from,travel_to,number_of_pessengers,travel_price,itenary_id,car_type_id)
VALUES
  (11,'2012-05-06','03:12:13',1,3,13,0,1,3),
  (12,'2017-06-04','11:20:10',1,7,13,0,1,4),
  (13,'2018-01-06','10:12:11',1,1,13,0,1,1),
  (14,'2011-05-01','03:10:09',1,2,13,0,1,2),
  (15,'2014-06-04','11:12:15',1,8,13,0,1,1),
  (16,'2010-05-01','11:25:10',1,9,13,0,1,4),
  (17,'2003-06-01','05:30:11',1,4,13,0,1,3),
  (18,'2013-06-05','11:20:11',1,5,13,0,1,2),
  (19,'2014-04-06','11:32:15',1,6,13,0,1,1);

-- INSERT INTO price
-- (price_id,travel_from,travel_to,distance,travel_time,saloon_price,van_price,bus_price,coach_price)
-- VALUES
--  (1,1,1,0.0,'0 mins',0,0,0,0),
--  (2,1,2,1.6,'5 mins',5,5,0,0),
--  (3,1,3,1.6,'5 mins',5,5,0,0),
--  (4,1,4,4.5,'8 mins',10,10,0,0),
--  (5,1,5,7.5,'20 mins',20,25,0,0),
--  (6,1,6,12,'30 mins',25,30,0,0),
--  (7,1,7,25,'60 mins',50,55,0,0),
--  (8,1,8,52,'1 hour 20 mins',80,90,0,0),
--  (9,1,9,85,'1 hour  50 mins',120,140,0,0),
--  (10,1,10,14.5,'30 mins',30,35,0,0),
--  (11,1,11,50,'1 hour 15 mins',80,90,0,0),
--  (12,1,12,82,'1 hours  50 mins',120,140,0,0),
--  (13,1,13,83,'2 hours',120,140,0,0),
--  (14,1,14,115,'2 hours 20 mins',150,170,0,0),
--  (15,1,15,14,'30 mins',25,30,0,0),
--  (16,1,16,35,'60 mins',60,70,0,0),
--  (17,1,17,60,'1 hour 30 mins',90,100,0,0),
--  (18,1,18,74,'1 hour 40 mins',110,120,0,0),
--  (19,1,19,79,'1 hour 50 mins',110,130,0,0);




INSERT INTO user_details
(user_id,user_email,password,user_role)
VALUES
  (1,'user@gmail.com','user','USER'),
  (2,'admin@gmail.com','admin','ADMIN');

INSERT INTO destinations
 (destination_id,destination_name)
VALUES
 (1,'St Andrews'),
 (2,'Eden Club House'),
 (3,'Links Club House'),
 (4,'Castle Course'),
 (5,'Kings Barns'),
 (6,'Crail Golf'),
 (7,'Carnoustie'),
 (8,'Glen Eagles'),
 (9,'North Berwick'),
 (10,'Dundee AP'),
 (11,'Edinburgh AP'),
 (12,'Glasgow AP'),
 (13,'Aberdeen AP'),
 (14,'Prestwick AP'),
 (15,'Dundee'),
 (16,'Perth'),
 (17,'Edinburgh'),
 (18,'Glasgow'),
 (19,'Aberdeen');


INSERT INTO distance
	(travel_from,travel_to,distance)
VALUES
	(1,1,0),
	(1,2,2),
	(1,3,1),
	(1,4,8),
	(1,5,8),
	(1,6,12),
	(1,7,24),
	(1,8,52),
	(1,9,82),
	(1,10,15),
	(1,11,50),
	(1,12,82),
	(1,13,84),
	(1,14,105),
	(1,15,14),
	(1,16,35),
	(1,17,53),
	(1,18,73),
	(1,19,79),
	(2,2,0),
	(2,3,2),
	(2,4,5),
	(2,5,10),
	(2,6,14),
	(2,7,23),
	(2,8,51),
	(2,9,82),
	(2,10,14),
	(2,11,50),
	(2,12,82),
	(2,13,84),
	(2,14,104),
	(2,15,14),
	(2,16,34),
	(2,17,52),
	(2,18,72),
	(2,19,78),
	(3,3,0),
	(3,4,4),
	(3,5,9),
	(3,6,13),
	(3,7,24),
	(3,8,52),
	(3,9,83),
	(3,10,15),
	(3,11,51),
	(3,12,83),
	(3,13,84),
	(3,14,105),
	(3,15,14),
	(3,16,35),
	(3,17,54),
	(3,18,73),
	(3,19,79),
	(4,4,0),
	(4,5,7),
	(4,6,10),
	(4,7,27),
	(4,8,55),
	(4,9,82),
	(4,10,18),
	(4,11,50),
	(4,12,94),
	(4,13,86),
	(4,14,117),
	(4,15,17),
	(4,16,38),
	(4,17,53),
	(4,18,85),
	(4,19,81),
	(5,5,0),
	(5,6,5),
	(5,7,32),
	(5,8,60),
	(5,9,84),
	(5,10,23),
	(5,11,52),
	(5,12,96),
	(5,13,91),
	(5,14,118),
	(5,15,22),
	(5,16,43),
	(5,17,55),
	(5,18,86),
	(5,19,86),
	(6,6,0),
	(6,7,36),
	(6,8,55),
	(6,9,85),
	(6,10,27),
	(6,11,52),
	(6,12,96),
	(6,13,96),
	(6,14,119),
	(6,15,26),
	(6,16,44),
	(6,17,55),
	(6,18,87),
	(6,19,91),
	(7,7,0),
	(7,8,51),
	(7,9,103),
	(7,10,14),
	(7,11,71),
	(7,12,101),
	(7,13,65),
	(7,14,124),
	(7,15,14),
	(7,16,34),
	(7,17,74),
	(7,18,91),
	(7,19,60),
	(8,8,0),
	(8,9,81),
	(8,10,37),
	(8,11,49),
	(8,12,54),
	(8,13,109),
	(8,14,77),
	(8,15,40),
	(8,16,18),
	(8,17,45),
	(8,18,45),
	(8,19,104),
	(9,9,0),
	(9,10,90),
	(9,11,163),
	(9,12,79),
	(9,13,163),
	(9,14,102),
	(9,15,94),
	(9,16,74),
	(9,17,25),
	(9,18,70),
	(9,19,158),
	(10,10,0),
	(10,11,57),
	(10,12,87),
	(10,13,76),
	(10,14,110),
	(10,15,4),
	(10,16,20),
	(10,17,60),
	(10,18,78),
	(10,19,71),
	(11,11,0),
	(11,12,58),
	(11,13,130),
	(11,14,71),
	(11,15,55),
	(11,16,49),
	(11,17,9),
	(11,18,39),
	(11,19,125),
	(12,12,0),
	(12,13,159),
	(12,14,37),
	(12,15,90),
	(12,16,67),
	(12,17,55),
	(12,18,11),
	(12,19,154),
	(13,13,0),
	(13,14,182),
	(13,15,71),
	(13,16,92),
	(13,17,132),
	(13,18,150),
	(13,19,7),
	(14,14,0),
	(14,15,113),
	(14,16,91),
	(14,17,79),
	(14,18,34),
	(14,19,177),
	(15,15,0),
	(15,16,23),
	(15,17,63),
	(15,18,81),
	(15,19,66),
	(16,16,0),
	(16,17,44),
	(16,18,62),
	(16,19,86),
	(17,17,0),
	(17,18,46),
	(17,19,127),
	(18,18,0),
	(18,19,46),
	(19,19,0);

