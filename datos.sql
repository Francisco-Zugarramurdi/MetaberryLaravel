insert into sports(name, photo) values ('Futbol','photo.com'), 
('Tenis','photo.com'), 
('Ping Pong','photo.com'); 
insert into countries(name, photo) values ('Uruguay','photo.com'), 
('Argentina','photo.com'), 
('Brasil','photo.com'); 
insert into players(name, surname, photo) values ('Luis','Suarez','photo.com'), 
('Luis','Perez','photo.com'), 
('Martin','Rodriguez','photo.com'), 
('Joaquín','Smith','photo.com'), 
('Estaban','Smith','photo.com'), 
('Martin','Perez','photo.com'), 
('Martin','Smith','photo.com'), 
('Arturo','Lopéz','photo.com'), 
('Alberto','DiAlberto','photo.com'), 
('Joaquín','Smith','photo.com'), 
('Estaban','DiAlberto','photo.com'), 
('Joaquín','Williams','photo.com'), 
('Arturo','Smith','photo.com'), 
('Alberto','Lopéz','photo.com'), 
('Estaban','Smith','photo.com'), 
('Alberto','Rodirguez','photo.com'), 
('Viviana','Caramelli','photo.com'), 
('Viviana','Lopéz','photo.com'), 
('Joaquín','DiMario','photo.com'), 
('Arturo','Williams','photo.com'), 
('Joaquín','DiMario','photo.com'), 
('Nicolas','DiMario','photo.com'), 
('Alberto','Williams','photo.com'), 
('Arturo','Perez','photo.com'), 
('Joaquín','Lopéz','photo.com'), 
('Arturo','McArthur','photo.com'), 
('Juana','Jhons','photo.com'), 
('Viviana','Perez','photo.com'), 
('Alberto','Rodirguez','photo.com'), 
('Alberto','Williams','photo.com'), 
('Estaban','Perez','photo.com'), 
('Viviana','Sosa','photo.com'),
('Joaquín','Caramelli','photo.com'), 
('Alberto','Williams','photo.com'), 
('Alberto','Rodirguez','photo.com'), 
('Martin','DiAlberto','photo.com'), 
('Nicolas','Perez','photo.com'), 
('Alberto','DiAlberto','photo.com'), 
('Mario','Williams','photo.com'), 
('Arturo','DiMario','photo.com'), 
('Viviana','Sosa','photo.com'), 
('Mario','McArthur','photo.com'); 
insert into events(name, details, id_sports, id_countries, date,  relevance) values 
('Gran parque central, team1 vs team2','Se juega en el parque  central',1,1,"2022-01-01",5), 
('Campeon del siglo, team2 vs team2','Se juega en la  bombonera',1,2,"2022-02-01",4), 
('Mesa 3, player1 vs player2','Partidazo bien picante',3,3,"2022-03-01",2); 
insert into teams(name, type_teams, id_sports, id_countries, photo) values ('Nacional', 'grupal',1,1,'photo.com'), 
('Boca', 'grupal',1,2,'photo.com'), 
('Peñarol', 'grupal',1,1,'photo.com'), 
('Racing', 'grupal',1,2,'photo.com'), 
('PingPong team1', 'grupal',3,3,'photo.com'), 
('PingPong team2', 'grupal',3,2,'photo.com'); 
insert into players_teams(id_players, id_teams, contract_start, contract_end, status) values (1,1,"2020-01-01","2022-12-12","Active"), 
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
(13,2,"2020-01-01","2022-12-12","Active"), 
(14,2,"2020-01-01","2022-12-12","Active"),
(15,2,"2020-01-01","2022-12-12","Active"), 
(16,2,"2020-01-01","2022-12-12","Active"), 
(17,2,"2020-01-01","2022-12-12","Active"), 
(18,2,"2020-01-01","2022-12-12","Active"), 
(19,2,"2020-01-01","2022-12-12","Active"), 
(20,2,"2020-01-01","2022-12-12","Active"), 
(21,3,"2020-01-01","2022-12-12","Active"), 
(22,3,"2020-01-01","2022-12-12","Active"), 
(23,3,"2020-01-01","2022-12-12","Active"), 
(24,3,"2020-01-01","2022-12-12","Active"), 
(25,3,"2020-01-01","2022-12-12","Active"), 
(26,4,"2020-01-01","2022-12-12","Active"), 
(27,4,"2020-01-01","2022-12-12","Active"), 
(28,4,"2020-01-01","2022-12-12","Active"), 
(29,4,"2020-01-01","2022-12-12","Active"), 
(30,4,"2020-01-01","2022-12-12","Active"), 
(31,5,"2020-01-01","2022-12-12","Active"), 
(32,6,"2020-01-01","2022-12-12","Active"); 
insert into extras(name, surname, rol, photo) values ('Sandro','Brown','Otro','photo.com'), 
('John','Mayer','Director técnico','photo.com'), 
('Walter','Diaz','Director técnico','photo.com'), 
('John','Williams','Coach','photo.com'), 
('Walter','Diaz','Preparador Fisico','photo.com'), 
('Walter','Blanco','Coach','photo.com'), 
('Jesus','Ruiz','Coach','photo.com'), 
('Ken','Ruiz','Preparador Fisico','photo.com'), 
('Ken','Ruiz','Preparador Fisico','photo.com'), 
('Ronald','Blanco','Preparador Fisico','photo.com'), 
('Sandro','Wagner','Preparador Fisico','photo.com'), 
('Jesus','Williams','Coach','photo.com'), 
('Jesus','Williams','Coach','photo.com'), 
('Sandro','Johnson','Otro','photo.com'), 
('Walter','Wagner','Preparador Fisico','photo.com'), 
('Marie','Diaz','Otro','photo.com'), 
('Walter','Castro ','Preparador Fisico','photo.com'),
 ('Ken','Castro ','Coach','photo.com'), 
('Sandro','Black','Coach','photo.com'), 
('Ken','Johnson','Coach','photo.com'), 
('Walter','Williams','Preparador Fisico','photo.com'), 
('John','Williams','Preparador Fisico','photo.com'), 
('Ken','O Ryan','Otro','photo.com'), 
('Jesus','Ruiz','Otro','photo.com'), 
('John','Moser','Preparador Fisico','photo.com'), 
('Sofia','Blanco','Director técnico','photo.com'), 
('Walter','Wagner','Otro','photo.com'), 
('Lucas','Mayer','Director técnico','photo.com'),
 ('Marie','Johnson','Preparador Fisico','photo.com'),
  ('Lucas','Wagner','Otro','photo.com'), 
('Walter','Diaz','Coach','photo.com'),
('John','Wagner','Preparador Fisico','photo.com'), 
('Sofia','Mayer','Preparador Fisico','photo.com'), 
('Marie','O Ryan','Preparador Fisico','photo.com'), 
('Francisco','Brown','Director técnico','photo.com'), 
('Ken','Williams','Otro','photo.com'), 
('Ronald','Diaz','Director técnico','photo.com'), 
('Marie','Diaz','Coach','photo.com'), 
('Ronald','O Ryan','Preparador Fisico','photo.com'), 
('Jesus','Wagner','Preparador Fisico','photo.com'), 
('Sandro','Johnson','Coach','photo.com'), 
('Sofia','Black','Director técnico','photo.com'), 
('Ronald','Wagner','Preparador Fisico','photo.com'), 
('Ken','Blanco','Coach','photo.com'), 
('Jesus','Castro ','Preparador Fisico','photo.com'); 
insert into extra_compose(id_extra, id_teams, contract_start, contract_end) values (1,1,"2022-02-01","2022-12-12"), 
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
(6,3); 
insert into leagues(name, details, photo) values 
('Copa Libertadores','La Copa Libertadores de América, denominada  oficialmente Copa Conmebol Libertadores, es un torneo anual  internacional oficial de fútbol organizado por la Confederación  Sudamericana de Fútbol, creado en 1960 bajo la denominación de Copa de  Campeones de América o Copa Campeones de América','photo.com'), 
('Liga PongPingPam', 'Se juega al ping pong re piola','photo.com'); 
insert into leagues_events(id_events, id_leagues) values (1,1),
(2,1), 
(3,2); 
insert into leagues_countries(id_leagues, id_countries) values (1,1), 
(2,3); 
insert into sanctions(id_events, sancion) values 
(1,'Tarjeta Amarilla'), 
(1,'Tarjeta Roja'), 
(2,'Tarjeta Amarilla'), 
(2,'Tarjeta Roja'); 
insert into sanctions_players(id_sancion, id_players, dates) values (1,1,"2022-01-01"), 
(1,11,"2022-01-01"), 
(3,12,"2022-01-01"), 
(4,14,"2022-01-01"), 
(1,13,"2022-01-01"); 
insert into referee(name, surname, photo) values 
('Pedro', 'PicaPiedra','photo.com'), 
('Hernesto', 'Perez','photo.com'); 
insert into referee_events(id_referee, id_events, dates) values (1,1,"2022-01-01"), 
(2,2,"2022-01-01"); 
insert into users_data(name,points,type_of_user,total_points, photo, credit_card)  values 
('Lukitas',10000,'pago',240000,'photo.com','credit_card'), 
('Yves',3000,'pago',20000,'photo.com','credit_card'), 
('Zara',9000,'pago',100000,'photo.com','credit_card'), 
('Fede',100,'gratis',100,'photo.com','credit_card'), 
('Nico',5000,'pago',6000,'photo.com','credit_card'); 
insert into users(id, name, email,password) values 
(1,'Lucas Medina','lucasmedina@gmail.com','HASH01Lucas'), (2,'Yves Motta','yvesmotta1@gmail.com','HASH01Yves'), 
(3,'Zara zugarramurdi','zarita@gmail.com','HASH01Zara'), (4,'Fede  
Notienesurname','elfedefacha@gmail.com','Fedenotienehasheadalacontra'),
(5,'Nicolas Mora','nico@gmail.com','HASH01Nico'); 
insert into post(post, id_users_data,dates,id_events,number_of_likes) values ('Andrew Tate idolo por siempre',1,"2022-01-01",1,1000), 
('Andrew es un pelado facha',4,"2022-01-01",1,1000), 
('Que lindos colores los de las camisetas!',2,"2022-01-01",2,1000), 
('Primer y unico comments(CaritaFachera)',3,"2022-01-01",3,1000), 
('Primero si, unico no jaja',5,"2022-01-01",3,1000); 
insert into user_likes(id_post, id_users_data) values (1,1), 
(1,2), 
(1,3), 
(1,4), 
(2,1), 
(3,1); 
insert into premium_league(id_users_data, id_leagues) values (1,1), 
(1,2), 
(2,2), 
(3,1), 
(3,2), 
(4,1), 
(5,1), 
(5,2); 
insert into premium_sports(id_users_data, id_sports) values (1,1), 
(1,3), 
(2,2), 
(3,3), 
(3,2), 
(4,1), 
(5,3), 
(5,2); 
insert into premium_events(id_users_data, id_events) values (1,1), 
(1,3), 
(2,2), 
(3,3), 
(3,2),
(4,1), 
(5,3), 
(5,2); 
insert into premium_teams(id_users_data, id_teams) values (1,1), 
(1,2), 
(1,5), 
(2,4), 
(2,2), 
(3,3), 
(3,2), 
(4,1), 
(5,4), 
(5,5); 
insert into favourite_user(id_users_data, id_teams) values (1,1), 
(2,2), 
(3,4), 
(1,5), 
(5,6); 
insert into results(results, id_events,type_results) values 
('Ganador Boca',1,'points'), 
('Ganador Racing',2,'points'), 
('Ganador Team1',3,'points'); 
insert into bets(amount, id_users_data, id_events, id_teams, dates)  values 
(240000,1,1,1,"2022-01-01"), 
(1000,2,1,1,"2022-01-01"), 
(42000,3,1,1,"2022-01-01"), 
(200,5,1,1,"2022-01-01"), 
(100,2,2,4,"2022-01-01"), 
(10230,3,2,4,"2022-01-01"), 
(1120,4,2,4,"2022-01-01");

insert into ads (view_counter, views_hired, url, image, size) values
(1,10,'url.url','sphoto.com','small'),
(1,10,'url.url','bigphoto.com','big'),
(1,10,'url.url','mphoto.com','medium'),
(1,10,'url.url','photous.com','ultra'),
(1,10,'url.url','photo.com','big');

insert into tags(tag) values
('Futbol'),
('Tenis'),
('PingPong');

insert into ad_tags(id_tag, id_ad) values
(1,1),
(2,3),
(1,2);