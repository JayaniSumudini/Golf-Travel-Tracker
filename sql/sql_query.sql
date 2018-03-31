drop database if exists golf_travel_route;
create database golf_travel_route;

use golf_travel_route;

drop table if exists party_details;
drop table if exists itenary;
drop table if exists trip;
drop table if exists destinations;
drop table if exists pricing;

create table user_details(
  user_id int not null AUTO_INCREMENT,
  user_email varchar(100) not null,
  password varchar(32) not null,
  reset_key varchar(100),
  PRIMARY KEY(user_id)
);

create table party_details(
	party_id int not null AUTO_INCREMENT,
	lead_name varchar(100),
	phone_number int,
	email varchar(100) not null,
	hotel_address varchar(200),
	flight_number varchar(200) not null,
	notes varchar(250),
	number_in_party varchar(100),
	user_id int not null,
	PRIMARY KEY(party_id),
	FOREIGN KEY(user_id)REFERENCES user_details(user_id)  ON DELETE CASCADE ON UPDATE CASCADE
);

create table itenary(
  itenary_id int not null AUTO_INCREMENT,
  party_id int not null,
  status enum ('NEW','SAVE','SUBMITED','ACCEPTED','ADMIN_CHANGED','TO_BE_ACCEPTANCE') not null DEFAULT 'NEW',
  total_price decimal(6,2) not null default 0.0,
  PRIMARY KEY(itenary_id),
  FOREIGN KEY(party_id)REFERENCES party_details(party_id)  ON DELETE CASCADE ON UPDATE CASCADE
);

create table destinations(
	destination_id int not null AUTO_INCREMENT,
	destination_name varchar(50) not null,
	destination_type enum ('TRAVEL' , 'PLACE') not null,
	distance decimal not null,
	travel_time varchar(100) not null,
	saloon_price decimal(6,2) not null,
	van_price decimal(6,2) not null,
	mini_bus_price decimal(6,2) not null,
	coach_price decimal(6,2) not null,
	PRIMARY KEY(destination_id)
);

create table trip(
  trip_id int not null AUTO_INCREMENT,
	travel_date date not null,
	travel_time time not null,
	travel_from_to int not null DEFAULT 0,
	place_from_to int not null DEFAULT 0,
	number_of_pessengers int not null,
	travel_price decimal(6,2),
	itenary_id int not null ,
	number_of_saloon int not null DEFAULT 0,
	number_of_van int not null DEFAULT 0,
	number_of_bus int not null DEFAULT 0,
	number_of_caoch int not null DEFAULT 0,
	PRIMARY KEY(trip_id),
	FOREIGN KEY(itenary_id) REFERENCES itenary(itenary_id)  ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(travel_from_to) REFERENCES destinations(destination_id)  ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(place_from_to) REFERENCES destinations(destination_id)  ON DELETE CASCADE ON UPDATE CASCADE
);


