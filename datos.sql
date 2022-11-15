insert into sports(name, icon) values 
('Futbol','sports_soccer'), 
('Tenis','sports_tennis'), 
('Ping Pong','sports_handball'),
('Carreras','sports_motorsports'), 
('Piscina','pool'), 
('Basket','sports_basketball'), 
('Gym','sports_gymnastics'), 
('Surf','surfing'), 
('Golf','sports_golf'), 
('Volley','sports_volleyball'), 
('MMA','sports_martial_arts'), 
('Rugby','sports_rugby'), 
('Boxeo','sports_mma'), 
('Patin','roller_skating');
insert into countries(name, photo) values 
('Uruguay','uru.jpg'), 
('Argentina','arg.jpg'), 
('Brasil','bra.jpg'),
('Estados Unidos','eeuu.jpg'), 
('Chile','chi.jpg'), 
('Alemania','ale.jpg'), 
('España','esp.jpg');
insert into players(name, surname, photo) values 
('Luis','Suarez','1.jpg'), 
('Luis','Perez','2.png'), 
('Martin','Rodriguez','3.jpg'), 
('Joaquín','Smith','4.jpg'), 
('Estaban','Smith','5.jpg'), 
('Martin','Perez','6.jpg'), 
('Martin','Smith','7.jpg'), 
('Arturo','Lopéz','8.jpg'), 
('Alberto','DiAlberto','9.jpg'), 
('Joaquín','Smith','10.jpg'), 
('Estaban','DiAlberto','11.jpg'), 
('Joaquín','Williams','12.jpg'), 
('Arturo','Smith','13.png'), 
('Alberto','Lopéz','14.jpg'), 
('Estaban','Smith','15.jpg'), 
('Alberto','Rodirguez','16.jpg'), 
('Viviana','Caramelli','17.png'), 
('Viviana','Lopéz','18.jpg'), 
('Joaquín','DiMario','19.jpg'), 
('Arturo','Williams','20.jpg'), 
('Joaquín','DiMario','21.jpg'), 
('Nicolas','DiMario','22.jpg'), 
('Alberto','Williams','23.jpg'), 
('Arturo','Perez','24.jpg'), 
('Joaquín','Lopéz','25.jpg'), 
('Arturo','McArthur','26.jpg'), 
('Juana','Jhons','27.jpg'), 
('Viviana','Perez','28.png'), 
('Alberto','Rodirguez','29.png'), 
('Alberto','Williams','30.jpg'), 
('Estaban','Perez','31.png'), 
('Viviana','Sosa','32.png'),
('Joaquín','Caramelli','35.jpg'), 
('Alberto','Williams','36.jpg'), 
('Alberto','Rodirguez','37.jpg'), 
('Martin','DiAlberto','38.jpg'), 
('Nicolas','Perez','39.jpg'), 
('Alberto','DiAlberto','40.jpg'), 
('Mario','Williams','33.png'), 
('Arturo','DiMario','34.jpg'), 
('Viviana','Sosa','default_img_do_not_delete.jpg'), 
('Mario','McArthur','default_img_do_not_delete.jpg'); 

insert into events(name, details, id_sports, id_countries, date,  relevance) values 
('Gran parque central','Se juega en el parque  central',1,1,"2022-01-01",5),
('Campeon del siglo','Se juega en la  bombonera',1,2,"2022-02-01",4),
('Partido de Tennis','Se juega en el club nautico',2,1,"2022-01-01",5), 
('Carrera de autos','Se corre en Nascar',4,6,"2022-01-01",5), 
('Carrera de personas','Se corre en el hipodromo',4,5,"2022-01-01",5); 

insert into teams(name, type_teams, id_sports, id_countries, photo) values 
('Nacional', 'Group',1,1,'nacional.png'), 
('Boca', 'Group',1,2,'boca.png'), 
('Peñarol', 'Group',1,1,'peñarol.png'), 
('Racing', 'Group',1,2,'racing.png'), 
('Tennis team1', 'Individual',2,2,'tennis1.jpg'), 
('Tennis team2', 'Individual',2,2,'tennis2.jpg'),
('Auto1', 'Individual',4,6,'Auto1.jpg'), 
('Auto2', 'Individual',4,6,'Auto2.jpg'), 
('Auto3', 'Individual',4,6,'Auto3.jpg'), 
('Auto4', 'Individual',4,6,'Auto4.jpg'), 
('Corredor1', 'Individual',4,5,'Corredor1.jpg'), 
('Corredor2', 'Individual',4,5,'Corredor2.jpg');

insert into players_teams(id_players, id_teams, contract_start, contract_end, status) values 
(1,1,"2020-01-01","2022-12-12","Active"), 
(2,1,"2020-01-01","2022-12-12","Active"), 
(3,1,"2020-01-01","2022-12-12","Active"), 
(4,1,"2020-01-01","2022-12-12","Active"), 
(5,1,"2020-01-01","2022-12-12","Active"), 
(6,1,"2020-01-01","2022-12-12","Active"), 
(7,1,"2020-01-01","2022-12-12","Active"), 
(8,1,"2020-01-01","2022-12-12","Active"), 
(9,1,"2020-01-01","2022-12-12","Active"), 
(10,1,"2020-01-01","2022-12-12","Active"), 
(11,2,"2020-01-01","2022-12-12","Active"), 
(12,2,"2020-01-01","2022-12-12","Active"), 
(13,2,"2020-11-01","2022-12-12","Active"), 
(14,2,"2020-11-01","2022-12-12","Active"),
(15,2,"2020-11-01","2022-12-12","Active"), 
(16,2,"2020-11-01","2022-12-12","Active"), 
(17,2,"2020-12-01","2022-12-12","Active"), 
(18,2,"2020-10-01","2022-12-12","Active"), 
(19,2,"2020-10-01","2022-12-12","Active"), 
(20,2,"2020-12-01","2022-12-12","Active"), 
(21,3,"2020-11-01","2022-12-12","Active"), 
(22,3,"2020-11-01","2022-12-12","Active"), 
(23,3,"2020-04-01","2022-12-12","Active"), 
(24,3,"2020-05-01","2022-12-12","Active"), 
(25,3,"2020-06-01","2022-12-12","Active"), 
(26,4,"2020-07-01","2022-12-12","Active"), 
(27,4,"2020-08-01","2022-12-12","Active"), 
(28,4,"2020-09-01","2022-12-12","Active"), 
(29,4,"2020-07-01","2022-12-12","Active"), 
(30,4,"2020-08-01","2022-12-12","Active"), 
(31,5,"2020-09-01","2022-12-12","Active"), 
(32,6,"2020-11-01","2022-12-12","Active"),
(39,5,"2020-01-01","2022-12-12","Active"), 
(40,6,"2020-03-01","2022-12-12","Active"),
(33,7,"2020-05-01","2022-12-12","Active"),
(34,8,"2020-06-01","2022-12-12","Active"),
(35,9,"2020-05-01","2022-12-12","Active"),
(36,10,"2020-01-11","2022-12-12","Active"),
(37,11,"2020-11-01","2022-12-12","Active"),
(38,12,"2020-03-01","2022-12-12","Active");
insert into extras(name, surname, rol, photo) values 
('Sandro','Brown','Otro','default_img_do_not_delete.jpg'), 
('John','Mayer','Director técnico','default_img_do_not_delete.jpg'), 
('Walter','Diaz','Director técnico','default_img_do_not_delete.jpg'), 
('John','Williams','Coach','default_img_do_not_delete.jpg'), 
('Walter','Diaz','Preparador Fisico','default_img_do_not_delete.jpg'), 
('Walter','Blanco','Coach','default_img_do_not_delete.jpg'), 
('Jesus','Ruiz','Coach','default_img_do_not_delete.jpg');
insert into extra_compose(id_extra, id_teams, contract_start, contract_end) values 
(1,1,"2022-02-01","2022-12-12"), 
(2,1,"2022-02-01","2022-12-12"), 
(5,1,"2022-02-01","2022-12-12"), 
(3,2,"2022-02-01","2022-12-12"), 
(4,2,"2022-02-01","2022-12-12"), 
(6,5,"2022-02-01","2022-12-12"), 
(7,6,"2022-02-01","2022-12-12"); 
insert into events_teams(id_teams, id_events) values 
(1,1), 
(2,1), 
(3,2), 
(4,2), 
(5,3), 
(6,3), 
(7,4), 
(8,4), 
(9,4), 
(10,4), 
(11,5), 
(12,5);
insert into leagues(name, details, photo) values 
('Copa Libertadores','La Copa Libertadores de América, denominada  oficialmente Copa Conmebol Libertadores, es un torneo anual  internacional oficial de fútbol organizado por la Confederación  Sudamericana de Fútbol, creado en 1960 bajo la denominación de Copa de  Campeones de América o Copa Campeones de América','default_img_do_not_delete.jpg'), 
('Liga Tennis', 'Se juega al Tennis','default_img_do_not_delete.jpg'),
('Nascar', 'Fium','default_img_do_not_delete.jpg'); 
insert into leagues_events(id_events, id_leagues) values 
(1,1),
(2,1),
(3,2),
(4,3);
insert into leagues_countries(id_leagues, id_countries) values 
(1,1), 
(2,3),
(3,6);
insert into sanctions(id_events, sancion) values 
(1,'Tarjeta Amarilla'), 
(1,'Tarjeta Roja'), 
(2,'Tarjeta Amarilla'), 
(2,'Tarjeta Roja'); 
insert into sanctions_players(id_sancion, id_players, minute) values 
(1,1,10),
(2,2,10), 
(3,12,3), 
(4,14,4);
insert into referee(name, surname, photo) values 
('Pedro', 'PicaPiedra','default_img_do_not_delete.jpg'), 
('Hernesto', 'Perez','default_img_do_not_delete.jpg'); 
insert into referee_events(id_referee, id_events, dates) values 
(1,1,"2022-01-01"), 
(2,2,"2022-01-01"),
(1,3,"2022-01-01"),
(2,4,"2022-01-01"),
(2,5,"2022-01-01");
insert into users_data(name,points,type_of_user,total_points, photo, credit_card)  values 
('Lukitas',10000,'paid_yearly',240000,'default_img_do_not_delete.jpg','4321432143214321'), 
('Yves',3000,'paid_monthly',20000,'default_img_do_not_delete.jpg','4321432143214321'), 
('Zara',9000,'free',100000,'default_img_do_not_delete.jpg','4321432143214321'), 
('Fede',100,'free',100,'default_img_do_not_delete.jpg','4321432143214321'), 
('Nico',5000,'paid_monthly',6000,'default_img_do_not_delete.jpg','4321432143214321');
insert into users(id, name, email,password) values 
(1,'Lucas Medina','lucas.medina@gmail.com','$2a$12$8b5EvWx9fT8GDYW.RpaUEusP7wgE0Z915fH6l225MTp9VcVUim37W'), 
(2,'Yves Motta','yvesmotta1@gmail.com','$2a$12$CZnLkKx7/vBM46rTFZ7Uvu.XGIbieBuOoPPsysxYWpr0/y8zBmwSG'), 
(3,'Fran zugarramurdi','zarita@gmail.com','$2a$12$KhKxPUz5hk1jU6IeDfesZ.kDc.3bAYLkwWOiK1vjM6aLKn9OICfz6'), 
(4,'Fede Notienesurname','elfedefacha@gmail.com','$2a$12$gBR.edJZqqwa.NVW7vVwZOL.aQSCNV0jymf6EhKCApcjiVKncMknC'),
(5,'Nicolas Mora','nico@gmail.com','$2a$12$gBR.edJZqqwa.NVW7vVwZOL.aQSCNV0jymf6EhKCApcjiVKncMknC'); 
insert into premium_league(id_users_data, id_leagues) values 
(1,1), 
(1,2), 
(2,2), 
(3,1), 
(3,2), 
(4,1), 
(5,1), 
(5,2); 
insert into premium_sports(id_users_data, id_sports) values 
(1,1), 
(1,3), 
(2,2), 
(3,3), 
(3,2), 
(4,1), 
(5,3), 
(5,2); 
insert into premium_events(id_users_data, id_events) values 
(1,1), 
(2,2), 
(3,2),
(4,1),  
(5,2); 
insert into premium_teams(id_users_data, id_teams) values 
(1,1), 
(1,2), 
(1,5), 
(2,4), 
(2,2), 
(3,3), 
(3,2), 
(4,1), 
(5,4), 
(5,5); 
insert into favourite_user(id_users_data, id_teams) values 
(1,1), 
(2,2), 
(3,4), 
(1,5), 
(5,6); 

insert into results(results, id_events,type_results) values 
('Ganador Boca',1,'results_points'), 
('Ganador Racing',2,'results_points'),
('Ganador Tennis1',3,'points_sets'),
('Ganador Auto3',4,'results_downward'),
('Ganador Corredor2',5,'results_upward');

insert into points_sets(number_set, points_set, id_teams, id_results) values
(1,5,5,3),
(1,8,6,3),
(2,5,5,3),
(2,6,6,3);

insert into results_points(id_results, id_teams, point, id_players) values
(1,1,2,1),
(1,2,5,15),
(2,3,1,21),
(2,4,4,26);

insert into results_upward(id_results,id_teams,position,result) values
(5,11,2,10),
(5,12,1,12);

insert into results_downward(id_results,id_teams,position,result) values
(4,7,3,16),
(4,8,4,15),
(4,9,1,10),
(4,10,2,9);

insert into ads (view_counter, views_hired, url, image, size) values
(1,10,'cocacola.com','adsmall.jpg','small'),
(1,10,'youtube.com','adbig.jpg','big'),
(1,10,'google.com','admedium.jpg','medium'),
(1,10,'bet365.com','adultra.jpg','ultra'),
(1,10,'spotify.com','adbig.jpg','big'),
(1,10,'yahoo.com','adssmall.jpg','small'),
(1,10,'pedirotootot.com','addsmall.jpg','small');

insert into tags(tag) values
('Futbol'),
('Tenis'),
('PingPong'),
('Carreras');

insert into ad_tags(id_tag, id_ad) values
(1,1),
(2,2),
(3,3),
(2,4),
(2,5),
(2,6),
(1,7);

insert into users_subscriptions(id_users, type_of_subscription) values
(1,'paid_yearly'),
(2,'paid_monthly'),
(5,'paid_monthly');
