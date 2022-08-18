drop database metaberrystudios;
create database metaberrystudios;
use metaberrystudios;
create table deporte(
    id serial primary key,
    nombre varchar(50) not null,
    imagen text
);
 
create table pais(
    id serial primary key,
    nombre varchar(50) not null,
    bandera text
);
 
create table jugador(
    id serial primary key,
    nombre varchar(50) not null,
    apellido varchar(50) not null,
    foto text
);
 
create table eventos(
    id serial primary key,
    nombre varchar(50) not null,
    detalles text,
    id_deporte bigint unsigned,
    id_pais bigint unsigned,
    fecha date,
    relevancia tinyint,
    foreign key (id_deporte) references deporte(id),
    foreign key (id_pais) references pais(id)
);
 
create table equipo (
    id serial primary key,
    nombre varchar(50) not null,
    foto text,
    tipo_equipo varchar(10) not null,
    id_deporte bigint unsigned,
    id_pais bigint unsigned,
    foreign key (id_deporte) references deporte(id),
    foreign key (id_pais) references pais(id)
);
 
create table jugador_equipo (
    id_jugador bigint unsigned,
    id_equipo bigint unsigned,
    inicio_contrato date not null,
    primary key (id_jugador,id_equipo),
    foreign key (id_jugador) references jugador(id),
    foreign key (id_equipo) references equipo(id)
);
 
create table contrato_terminado(
    id_jugador bigint unsigned,
    id_equipo bigint unsigned,
    termino_contrato date,
    primary key (id_jugador,id_equipo),
    foreign key (id_jugador) references jugador_equipo(id_jugador),
    foreign key (id_equipo) references jugador_equipo(id_equipo)
);
 
create table extras(
    id serial primary key,
    nombre varchar(50) not null,
    apellido varchar(50) not null,
    foto text,
    rol varchar(50)
);
 
create table extra_compone(
    id_extra bigint unsigned,
    id_equipo bigint unsigned,
    inicio_contrato date not null,
    termino_contrato date,
    primary key (id_extra,id_equipo),
    foreign key (id_extra) references extras(id),
    foreign key (id_equipo) references equipo(id)
);
 
create table evento_equipo(
    id_equipo bigint unsigned,
    id_evento bigint unsigned,
    primary key (id_equipo,id_evento),
    foreign key (id_equipo) references equipo(id),
    foreign key (id_evento) references eventos(id)
);
 
create table ligas(
    id serial primary key,
    nombre varchar(50) not null,
    detalles text not null,
    imagen text
);
 
create table liga_evento(
    id_evento bigint unsigned,
    id_liga bigint unsigned,
    primary key (id_evento,id_liga),
    foreign key (id_evento) references eventos(id),
    foreign key (id_liga) references ligas(id)
);
 
create table liga_pais(
    id_pais bigint unsigned,
    id_liga bigint unsigned,
    primary key (id_pais,id_liga),
    foreign key (id_pais) references pais(id),
    foreign key (id_liga) references ligas(id)
);
 
create table sanciones(
    id serial,
    id_evento bigint unsigned,
    sancion varchar(50) not null,
    primary key (id,id_evento),
    foreign key (id_evento) references eventos(id)
);
 
create table sancion_jugador(
    id_sancion bigint unsigned,
    id_jugador bigint unsigned,
    fecha date not null,
    primary key (id_sancion,id_jugador),
    foreign key (id_sancion) references sanciones(id),
    foreign key (id_jugador) references jugador(id)
);
 
create table sancion_extra(
    id_sancion bigint unsigned,
    id_extra bigint unsigned,
    fecha date not null,
    primary key (id_sancion,id_extra),
    foreign key (id_sancion) references sanciones(id),
    foreign key (id_extra) references extras(id)
);
 
create table arbitro(
    id serial primary key,
    nombre varchar(50) not null,
    apellido varchar(50) not null,
    foto text
);
 
create table arbitro_evento(
    id_arbitro bigint unsigned,
    id_evento bigint unsigned,
    fecha date not null,
    primary key (id_arbitro,id_evento),
    foreign key (id_evento) references eventos(id),
    foreign key (id_arbitro) references arbitro(id)
);
 

 
create table users(
    id serial primary key,
	name varchar(255) not null,
	email varchar(255) not null,
	email_verified_at timestamp null default null,
	password varchar(255) not null,
	remember_token varchar(255) default null,
	created_at timestamp null default null,
	updated_at timestamp null default null
);
create table usuarios(
    id bigint unsigned primary key,
    username varchar(50) not null,
    tarjeta varchar(16),
    foto text,
    puntos bigint not null,
    tipo_de_usuario varchar(6),
    puntos_totales bigint,
    foreign key (id) references users(id)

);
 
create table post(
    id serial,
    posteo text not null,
    id_usuario bigint unsigned,
    fecha date not null,
    cantidad_likes bigint,
    id_evento bigint unsigned,
    primary key (id, id_usuario,id_evento),
    foreign key (id_usuario) references usuarios(id),
    foreign key (id_evento) references eventos(id)
);
create table like_usuario(
    id_post bigint unsigned,
    id_usuario bigint unsigned,
    primary key (id_post, id_usuario),
    foreign key (id_post) references post(id),
    foreign key (id_usuario) references usuarios(id)
);
 
create table comentario (
    id serial,
    comentario text,
    id_post bigint unsigned,
    id_usuario bigint unsigned,
    fecha date,
    es_hijo tinyint(1),
    primary key (id,id_post,id_usuario),
    foreign key (id_post) references post(id),
    foreign key (id_usuario) references usuarios(id)
);
 
create table comentario_padre(
    id_comentario_padre bigint unsigned,
    id_comentario_hijo bigint unsigned,
    primary key (id_comentario_padre,id_comentario_hijo),
    foreign key (id_comentario_padre) references comentario(id),
    foreign key (id_comentario_hijo) references comentario(id)
);
 
create table premios(
    id serial,
    premio varchar(50),
    id_usuario bigint unsigned,
    fecha_entrega date,
    primary key (id,id_usuario),
    foreign key (id_usuario) references usuarios(id)
);
 
create table usuariopago_liga(
    id_usuario bigint unsigned,
    id_liga bigint unsigned,
    primary key (id_usuario,id_liga),
    foreign key (id_usuario) references usuarios(id),
    foreign key (id_liga) references ligas(id)
);
 
create table usuariopago_deporte(
    id_usuario bigint unsigned,
    id_deporte bigint unsigned,
    primary key (id_usuario,id_deporte),
    foreign key (id_usuario) references usuarios(id),
    foreign key (id_deporte) references deporte(id)
);
 
create table usuariopago_evento(
    id_usuario bigint unsigned,
    id_evento bigint unsigned,
    primary key (id_usuario,id_evento),
    foreign key (id_usuario) references usuarios(id),
    foreign key (id_evento) references eventos(id)
);
 
create table usuariopago_equipo(
    id_usuario bigint unsigned,
    id_equipo bigint unsigned,
    primary key (id_usuario,id_equipo),
    foreign key (id_usuario) references usuarios(id),
    foreign key (id_equipo) references equipo(id)
);
 
create table usuario_favorito(
    id_usuario bigint unsigned,
    id_equipo bigint unsigned,
    primary key (id_usuario,id_equipo),
    foreign key (id_usuario) references usuarios(id),
    foreign key (id_equipo) references equipo(id)
);
 
create table resultado(
    id serial,
    tipo_resultado varchar(11),
    resultado varchar(25),
    id_evento bigint unsigned,
    primary key (id,id_evento),
    foreign key (id_evento) references eventos(id)
);
 
create table apuesta(
    id serial,
    monto int,
    id_usuario bigint unsigned,
    id_evento bigint unsigned,
    id_equipo bigint unsigned,
    fecha date,
    primary key (id,id_usuario,id_evento,id_equipo),
    foreign key (id_usuario) references usuarios(id),
    foreign key (id_equipo) references equipo(id),
    foreign key (id_evento) references eventos(id)
);
 
create table tantoset(
    numero_set tinyint,
    puntos_set int,
    id_equipo bigint unsigned,
    id_resultado bigint unsigned,
    primary key (id_equipo,id_resultado,numero_set),
    foreign key (id_equipo) references equipo(id),
    foreign key (id_resultado) references resultado(id)
);
 
create table resultado_tantos(
    id_resultado bigint unsigned,
    id_equipo bigint unsigned,
    tanto int,
    id_jugador bigint unsigned,
    primary key (id_resultado,id_equipo,id_jugador),
    foreign key (id_resultado) references resultado(id),
    foreign key (id_equipo) references equipo(id),
    foreign key (id_jugador) references jugador(id)
);
 
create table resultado_marcaas(
    id_resultado bigint unsigned,
    id_equipo bigint unsigned,
    posicion int,
    marca time,
    primary key (id_resultado,id_equipo),
    foreign key (id_resultado) references resultado(id),
    foreign key (id_equipo) references equipo(id)
);
 
create table resultado_marcades(
    id_resultado bigint unsigned,
    id_equipo bigint unsigned,
    posicion int,
    marca time,
    primary key (id_resultado,id_equipo),
    foreign key (id_resultado) references resultado(id),
    foreign key (id_equipo) references equipo(id)
);

select name, password from users;
