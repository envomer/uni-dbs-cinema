
CREATE TABLE cinemas (
  id NUMBER(20) NOT NULL, 
  cinema_name VARCHAR(20) NOT NULL, 
  street VARCHAR(20) NOT NULL, 
  zip NUMBER(20) NOT NULL, 
  city VARCHAR(20) DEFAULT '', 
  PRIMARY KEY (id) 
);


CREATE TABLE persons (
  id NUMBER(20) NOT NULL, 
  street VARCHAR(255) DEFAULT NULL, 
  zip VARCHAR(20) DEFAULT NULL, 
  city VARCHAR(255) DEFAULT NULL, 
  name VARCHAR(255) DEFAULT '', 
  PRIMARY KEY (id) 
);


CREATE TABLE customers (
  id NUMBER(20) NOT NULL, 
  email VARCHAR(20) NOT NULL, 
  password VARCHAR(20) NOT NULL, 
  person_id NUMBER(20) NOT NULL, 
  PRIMARY KEY (id), 
  CONSTRAINT customer_fk_person_id FOREIGN KEY (person_id) REFERENCES persons (id) ON DELETE CASCADE
);



CREATE TABLE employees (
  id NUMBER(20) NOT NULL,
  social_security_nr NUMBER(11) DEFAULT NULL,
  phone VARCHAR(62) DEFAULT NULL,
  person_id NUMBER(20) NOT NULL,
  cinema_id NUMBER(20) NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT employee_fk_cinema_id FOREIGN KEY (cinema_id) REFERENCES cinemas (id) ON DELETE CASCADE,
  CONSTRAINT employee_fk_person_id FOREIGN KEY (person_id) REFERENCES persons (id) ON DELETE CASCADE
);


CREATE TABLE movies (
  id NUMBER(20) NOT NULL,
  title VARCHAR(50) NOT NULL,
  duration NUMBER(5) NOT NULL,
  image VARCHAR(255),
  PRIMARY KEY (id)
);


CREATE TABLE rooms (
  id NUMBER(20) NOT NULL,
  cinema_id NUMBER(20) NOT NULL,
  name VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (id),
  CONSTRAINT room_fk_cinema_id FOREIGN KEY (cinema_id) REFERENCES cinemas (id) ON DELETE CASCADE
);

CREATE TABLE rooms (
  id NUMBER(20) NOT NULL,
  cinema_id NUMBER(20) NOT NULL,
  name VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (id),
  CONSTRAINT room_fk_cinema_id FOREIGN KEY (cinema_id) REFERENCES cinemas (id) ON DELETE CASCADE
);

CREATE TABLE equipments (
  id NUMBER(20) NOT NULL,
  three_d NUMBER(2) DEFAULT 0,
  imax NUMBER(2) DEFAULT 0,
  room_id NUMBER(2) DEFAULT 0,
  PRIMARY KEY (id),
  CONSTRAINT equipment_fk_room_id FOREIGN KEY (room_id) REFERENCES rooms (id) ON DELETE CASCADE
);

CREATE TABLE movie_slots (
  id NUMBER(20) NOT NULL,
  room_id NUMBER(20) NOT NULL,
  start_at TIMESTAMP DEFAULT NULL,
  movie_id NUMBER(20) NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT movieslot_fk_movie_id FOREIGN KEY (movie_id) REFERENCES movies (id) ON DELETE CASCADE,
  CONSTRAINT movieslot_fk_room_id FOREIGN KEY (room_id) REFERENCES rooms (id) ON DELETE CASCADE
);


CREATE TABLE tickets (
  id NUMBER(20) NOT NULL,
  purchased_at TIMESTAMP DEFAULT NULL,
  seat NUMBER(20) NOT NULL,
  row_nr NUMBER(20) NOT NULL,
  movie_slot_id NUMBER(20) NOT NULL,
  employee_id NUMBER(20) NOT NULL,
  customer_id NUMBER(20) NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT ticket_fk_slot_id FOREIGN KEY (movie_slot_id) REFERENCES movie_slots (id) ON DELETE CASCADE,
  CONSTRAINT ticket_fk_employee_id FOREIGN KEY (employee_id) REFERENCES employees (id) ON DELETE CASCADE,
  CONSTRAINT ticket_fk_customer_id FOREIGN KEY (customer_id) REFERENCES customers (id) ON DELETE CASCADE
);



CREATE SEQUENCE seq_cinemas_auto_increment START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE seq_persons_auto_increment START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE seq_customers_auto_increment START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE seq_employees_auto_increment START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE seq_movies_auto_increment START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE seq_rooms_auto_increment START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE seq_equipments_auto_increment START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE seq_movie_slots_auto_increment START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE seq_tickets_auto_increment START WITH 1 INCREMENT BY 1;


CREATE OR REPLACE TRIGGER trigger_cinemas BEFORE INSERT ON cinemas FOR EACH ROW
BEGIN
  SELECT seq_cinemas_auto_increment.nextval INTO :NEW.id FROM dual;
END;
/

CREATE OR REPLACE TRIGGER trigger_persons BEFORE INSERT ON persons FOR EACH ROW
BEGIN
  SELECT seq_persons_auto_increment.nextval INTO :NEW.id FROM dual;
END;
/

CREATE OR REPLACE TRIGGER trigger_customers BEFORE INSERT ON customers FOR EACH ROW
BEGIN
  SELECT seq_customers_auto_increment.nextval INTO :NEW.id FROM dual;
END;
/

CREATE OR REPLACE TRIGGER trigger_employees BEFORE INSERT ON employees FOR EACH ROW
BEGIN
  SELECT seq_employees_auto_increment.nextval INTO :NEW.id FROM dual;
END;
/

CREATE OR REPLACE TRIGGER trigger_movies BEFORE INSERT ON movies FOR EACH ROW
BEGIN
  SELECT seq_movies_auto_increment.nextval INTO :NEW.id FROM dual;
END;
/

CREATE OR REPLACE TRIGGER trigger_rooms BEFORE INSERT ON rooms FOR EACH ROW
BEGIN
  SELECT seq_rooms_auto_increment.nextval INTO :NEW.id FROM dual;
END;
/

CREATE OR REPLACE TRIGGER trigger_equipments BEFORE INSERT ON equipments FOR EACH ROW
BEGIN
  SELECT seq_equipments_auto_increment.nextval INTO :NEW.id FROM dual;
END;
/

CREATE OR REPLACE TRIGGER trigger_movie_slots BEFORE INSERT ON movie_slots FOR EACH ROW
BEGIN
  SELECT seq_movie_slots_auto_increment.nextval INTO :NEW.id FROM dual;
END;
/

CREATE OR REPLACE TRIGGER trigger_tickets BEFORE INSERT ON tickets FOR EACH ROW
BEGIN
  SELECT seq_tickets_auto_increment.nextval INTO :NEW.id FROM dual;
END;
/










-- CREATE VIEW movies_top AS
--   SELECT m.title, SUM(m.id)
--   FROM movies m INNER JOIN movie_slots s ON s.movie_id = m.id
-- GROUP BY m.id ORDER BY m.id;



/**
 * show all user tables
 */
SELECT table_name FROM user_tables;


DROP TABLE tickets;
DROP TABLE movie_slots;
DROP TABLE equipments;
DROP TABLE rooms;
DROP TABLE movies;
DROP TABLE employees;
DROP TABLE customers;
DROP TABLE persons;
DROP TABLE cinemas;

DROP SEQUENCE seq_cinemas_auto_increment;
DROP SEQUENCE seq_persons_auto_increment;
DROP SEQUENCE seq_customers_auto_increment;
DROP SEQUENCE seq_employees_auto_increment;
DROP SEQUENCE seq_movies_auto_increment;
DROP SEQUENCE seq_rooms_auto_increment;
DROP SEQUENCE seq_equipments_auto_increment;
DROP SEQUENCE seq_movie_slots_auto_increment;
DROP SEQUENCE seq_tickets_auto_increment;