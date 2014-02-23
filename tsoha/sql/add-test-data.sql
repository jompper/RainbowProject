INSERT INTO users (username, password, full_name, email, admin) VALUES ('admin', '1a583c12263cae4f81fa4a6127769343d315cab82cc5fcac7282924bfef2b680ef55f4d68e7e71b28be43d99872640e31180aaee1ee5fe7058c1b17cd81c6466', 'Puuha Pete','yrjo@yllapitaja.fi', true), ('basic', '9e5ca7d69288fa5efbf54d92de383234b6c5972725f7f713e60db6ab3d2b99c5affb900112cc4fc9c4fd83871261b53cd0c91a0b5b1a195eb7354dab72cb6f89', 'T. Tavallinen', 'tero@tavallinen.fi', false);
INSERT INTO priorities (priority, name) VALUES (5, 'Kiireellinen'), (3,'Normaali'), (1, 'Alhainen');
INSERT INTO statuses (name) VALUES ('Valmis'), ('Työn alla'), ('Jonossa'), ('Odottaa'), ('Keskeytetty');
INSERT INTO customers (priority_id, name, business_id, email, phone) VALUES (1,'Testikäs Oy', '1337133-7', 'testi@testikas.fi', '133 - 713 3713');
INSERT INTO projects (customer_id, priority_id, status_id, due_date, name, description) VALUES (1, 1, 1,'2014-02-23', 'Tuntiseuranta', 'Toteutetaan asiakkaalle tuntiseuranta- / projektinhallintajärjestelmä');
INSERT INTO tasks (project_id, priority_id, status_id, due_date, hour_estimate, name, description) VALUES (1,2,2,'2014-01-26',2,'Tietokanta','Toteutetaan järjestelmään tarvittava tietokanta'); 
INSERT INTO project_comments (user_id, project_id, comment) VALUES (2,1,'Projektiin on tulossa lisää tehtäviä seuraavien viikkojen aikana, tämä projekti on TOP-PRIORITY');
INSERT INTO user_tasks (user_id, task_id) VALUES (2, 1);
INSERT INTO user_task_hours (user_id, task_id, start_time, end_time, description) VALUES (1,1, '2014-01-26 14:00', '2014-01-26 18:00', 'Tietokanta + kaavioita + suunnittelua');
