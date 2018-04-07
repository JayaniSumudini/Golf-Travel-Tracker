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
  (party_id,lead_name,phone_number,email,hotel_address,flight_number,notes,user_id,number_in_party)
VALUES
  (1,'test1',1234567,'test1@gmail.com','test1,road,street,city','CDUW3445','abcdefghijklmnopqrstuvwxyz', 1,12),
  (2,'test2',1234567,'test2@gmail.com','test2,road,street,city','CDUW3445','abcdefghijklmnopqrstuvwxyz', 1,10),
  (3,'test3',1234567,'test3@gmail.com','test3,road,street,city','CDUW3445','abcdefghijklmnopqrstuvwxyz', 1,15),
  (4,'test4',1234567,'test4@gmail.com','test4,road,street,city','CDUW3445','abcdefghijklmnopqrstuvwxyz', 2,14),
  (5,'test5',1234567,'test5@gmail.com','test5,road,street,city','CDUW3445','abcdefghijklmnopqrstuvwxyz', 2,149),
  (6,'test6',1234567,'test6@gmail.com','test6,road,street,city','CDUW3445','abcdefghijklmnopqrstuvwxyz', 2,245),
  (7,'test7',1234567,'test7@gmail.com','test7,road,street,city','CDUW3445','abcdefghijklmnopqrstuvwxyz', 3,231),
  (8,'test8',1234567,'test8@gmail.com','test8,road,street,city','CDUW3445','abcdefghijklmnopqrstuvwxyz', 3,45),
  (9,'test9',1234567,'test9@gmail.com','test9,road,street,city','CDUW3445','abcdefghijklmnopqrstuvwxyz', 3,4),
  (10,'test10',1234567,'test10@gmail.com','test10,road,street,city','CDUW3445','abcdefghijklmnopqrstuvwxyz', 3,623);


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

INSERT INTO destinations
 (destination_id,destination_name,distance,travel_time,saloon_price,van_price,mini_bus_price,coach_price)
VALUES
 (1,'St Andrews',0.0,'0 mins',0,0,0,0),
 (2,'Eden Club House',1.6,'5 mins',5,5,0,0),
 (3,'Links Club House',1.6,'5 mins',5,5,0,0),
 (4,'Castle Course',4.5,'8 mins',10,10,0,0),
 (5,'Kings Barns',7.5,'20 mins',20,25,0,0),
 (6,'Crail Golf',12,'30 mins',25,30,0,0),
 (7,'Carnoustie',25,'60 mins',50,55,0,0),
 (8,'Glen Eagles',52,'1 hour 20mins',80,90,0,0),
 (9,'North Berwick',85,'1 hour  50 mins',120,140,0,0),
 (10,'Dundee AP',14.5,'30 mins',30,35,0,0),
 (11,'Edinburgh AP',50,'1 hour 15 mins',80,90,0,0),
 (12,'Glasgow AP',82,'1 hours  50 mins',120,140,0,0),
 (13,'Aberdeen AP',83,'2 hours',120,140,0,0),
 (14,'Prestwick AP',115,'2 hours 20 mins',150,170,0,0),
 (15,'Dundee',14,'30 mins',25,30,0,0),
 (16,'Perth',35,'60 mins',60,70,0,0),
 (17,'Edinburgh',60,'1 hour 30 mins',90,100,0,0),
 (18,'Glasgow',74,'1 hour 40 mins',110,120,0,0),
 (19,'Aberdeen',79,'1 hour 50 mins',110,130,0,0);


INSERT INTO trip
  (trip_id,travel_date,travel_time,travel_from,travel_to,number_of_pessengers,travel_price,itenary_id,number_of_saloon,number_of_van,number_of_bus,number_of_caoch)
VALUES
  (1,'2012-05-06','03:12:11',1,3,13,0,1,3,0,0,2),
  (2,'2017-06-04','11:23:10',1,7,13,0,2,4,0,1,2),
  (3,'2018-01-06','11:12:11',1,1,13,0,3,5,0,0,0),
  (4,'2011-05-01','03:10:11',1,2,13,0,4,4,1,0,1),
  (5,'2014-06-04','11:12:10',1,8,13,0,4,1,0,2,1),
  (6,'2010-05-01','11:23:10',1,9,13,0,6,0,0,2,0),
  (7,'2003-06-01','03:30:11',1,4,13,0,7,3,0,0,0),
  (8,'2013-06-05','11:10:11',1,5,13,0,8,3,0,2,0),
  (9,'2014-04-06','11:12:10',1,6,13,0,9,3,1,2,0),
  (10,'2015-01-01','03:23:11',1,7,13,0,10,1,1,0,0);

