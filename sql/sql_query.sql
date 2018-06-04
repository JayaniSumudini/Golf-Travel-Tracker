drop database if exists golf_travel_route;
create database golf_travel_route;

use golf_travel_route;

drop table if exists user_details;
drop table if exists party_details;
drop table if exists itenary;
drop table if exists trip;
drop table if exists destinations;
drop table if exists distance;
drop table if exists vehicle;

create table user_details(
  user_id int not null AUTO_INCREMENT,
  user_email varchar(100) not null,
  password varchar(32) not null,
  reset_key varchar(100),
  user_role enum ('USER','ADMIN') not null DEFAULT 'USER',
  PRIMARY KEY(user_id,user_email)
);

create table party_details(
	party_id int not null AUTO_INCREMENT,
	lead_name varchar(100),
	phone_number varchar(20),
	email varchar(100) not null,
	hotel_address varchar(200),
	notes varchar(250),
	number_in_party varchar(100),
	user_id int not null,
	create_date_and_time DATETIME not null,
	PRIMARY KEY(party_id),
	FOREIGN KEY(user_id)REFERENCES user_details(user_id)  ON DELETE CASCADE ON UPDATE CASCADE
);

create table itenary(
  itenary_id int not null AUTO_INCREMENT,
  party_id int not null,
  status enum ('NEW','SAVE','SUBMITED','ACCEPTED','ADMIN_CHANGED','TO_BE_ACCEPTANCE') not null DEFAULT 'NEW',
  total_price decimal(20,2) not null default 0.0,
  PRIMARY KEY(itenary_id),
  FOREIGN KEY(party_id)REFERENCES party_details(party_id)  ON DELETE CASCADE ON UPDATE CASCADE
);

create table destinations(
	destination_id int not null AUTO_INCREMENT,
	destination_name varchar(50) not null,
	PRIMARY KEY(destination_id)
);

create table vehicle(
 vehicle_id int not null AUTO_INCREMENT,
 vehicle_name varchar(200) not null,
 vehicle_price decimal(10,2),
 PRIMARY KEY(vehicle_id)
);

create table trip(
  trip_id int not null AUTO_INCREMENT,
	travel_date date not null,
	travel_time time not null,
	travel_from int not null DEFAULT 0,
	travel_to int not null DEFAULT 0,
	number_of_pessengers int not null,
	itenary_id int not null ,
	car_type_id int not null default 1,
	trip_status enum('Added','Saved','Submited','AdminChanged','ToBeAcceptance','Accepted') not null default 'Added',
	flight_number varchar(200) not null,
	travel_price decimal(10,2),
	PRIMARY KEY(trip_id),
	FOREIGN KEY(itenary_id) REFERENCES itenary(itenary_id)  ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(car_type_id) REFERENCES vehicle(vehicle_id)  ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(travel_from) REFERENCES destinations(destination_id)  ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(travel_to) REFERENCES destinations(destination_id)  ON DELETE CASCADE ON UPDATE CASCADE
);

create table distance(
 distance_id int not null AUTO_INCREMENT,
 travel_from int not null DEFAULT 0,
 travel_to int not null DEFAULT 0,
 distance decimal not null,
--  travel_time varchar(100) not null,
 PRIMARY KEY(distance_id),
 FOREIGN KEY(travel_from) REFERENCES destinations(destination_id)  ON DELETE CASCADE ON UPDATE CASCADE,
 FOREIGN KEY(travel_to) REFERENCES destinations(destination_id)  ON DELETE CASCADE ON UPDATE CASCADE
);
