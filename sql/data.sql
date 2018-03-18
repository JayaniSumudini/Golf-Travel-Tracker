INSERT INTO user_details
(user_id,user_email,password)
VALUES
  (1,'test1@gmail.com','test1'),
  (2,'test2@gmail.com','test2'),
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
  (itenary_id,party_id,status)
VALUES
  (1,1,'NEW'),
  (2,2,'NEW'),
  (3,3,'NEW'),
  (4,4,'NEW'),
  (5,5,'NEW'),
  (6,6,'NEW'),
  (7,7,'NEW'),
  (8,8,'NEW'),
  (9,9,'NEW'),
  (10,10,'NEW');

INSERT INTO trip
  (trip_id,travel_date,travel_time,travel_from,travel_to,number_of_pessengers,travel_price,itenary_id)
VALUES
  (1,'2012-05-06','03:12:11',1,3,13,null,1),
  (2,'2017-06-04','11:23:10',5,7,13,null,2),
  (3,'2018-01-06','11:12:11',2,1,13,null,3),
  (4,'2011-05-01','03:10:11',4,2,13,null,4),
  (5,'2014-06-04','11:12:10',3,8,13,null,4),
  (6,'2010-05-01','11:23:10',8,9,13,null,6),
  (7,'2003-06-01','03:30:11',9,4,13,null,7),
  (8,'2013-06-05','11:10:11',10,5,13,null,8),
  (9,'2014-04-06','11:12:10',2,6,13,null,9),
  (10,'2015-01-01','03:23:11',1,7,13,null,10);

INSERT INTO destinations
 (destination_id,destination_name,destination_type)
VALUES
 (1,'destinations1','RAIL'),
 (2,'destinations2','RAIL'),
 (3,'destinations3','RAIL'),
 (4,'destinations4','CITY'),
 (5,'destinations5','CITY'),
 (6,'destinations6','CITY'),
 (7,'destinations7','AIRPORT'),
 (8,'destinations8','AIRPORT'),
 (9,'destinations9','AIRPORT'),
 (10,'destinations10','GOLF'),
 (11,'destinations11','GOLF'),
 (12,'destinations12','GOLF'),
 (13,'destinations13','GOLF');

INSERT INTO pricing
 (price_id,travel_from,travel_to,miles,price_per_mile)
VALUES
 (1,1,3,12,34),
 (2,5,7,12,56),
 (3,2,1,12,56),
 (4,4,2,12,56),
 (5,3,8,12,56),
 (6,8,9,12,56),
 (7,9,4,12,56),
 (8,10,5,12,56),
 (9,2,6,12,56),
 (10,2,3,12,56);