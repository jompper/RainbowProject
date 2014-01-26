INSERT INTO roles (name) VALUES ('Administrator'),('Basic');
INSERT INTO users (role_id, username, password, full_name) VALUES (1, 'admin', '', 'Puuha Pete'), (2, 'basic', '', 'T. Tavallinen');
INSERT INTO priorities (priority, name) VALUES (5, 'Kiireellinen'), (3,'Normaali'), (1, 'Alhainen');
INSERT INTO statuses (name) VALUES ('Valmis'), ('Työn alla'), ('Jonossa'), ('Odottaa'), ('Keskeytetty');
INSERT INTO customers (priority_id, name, business_id) VALUES (1,'Testikäs Oy', '1337133-7');
INSERT INTO projects (customer_id, priority_id, name, description) VALUES (1, 1, 'Tuntiseuranta', 'Toteutetaan asiakkaalle tuntiseuranta- / projektinhallintajärjestelmä');
INSERT INTO tasks (project_id, priority_id, status_id, due_date, hour_estimate, name, description) VALUES (1,2,2,'2014-01-26',2,'Tietokanta','Toteutetaan järjestelmään tarvittava tietokanta'); 
INSERT INTO project_comments (user_id, project_id, title, comment) VALUES (2,1,'Jatkuu', 'Projektiin on tulossa lisää tehtäviä seuraavien viikkojen aikana, tämä projekti on TOP-PRIORITY');
INSERT INTO user_tasks (user_id, task_id) VALUES (2, 1);
