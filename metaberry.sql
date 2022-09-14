drop database metaberrystudios;
create database metaberrystudios;
use metaberrystudios;
create table sports(
    id serial primary key,
    name varchar(50) not null,
    photo text
);
 
create table countries(
    id serial primary key,
    name varchar(50) not null,
    photo text
);
 
create table players(
    id serial primary key,
    name varchar(50) not null,
    surname varchar(50) not null,
    photo text
);
 
create table events(
    id serial primary key,
    name varchar(50) not null,
    details text,
    id_sports bigint unsigned,
    id_countries bigint unsigned,
    dates date,
    relevance tinyint,
    foreign key (id_sports) references sports(id),
    foreign key (id_countries) references countries(id)
);
 
create table teams (
    id serial primary key,
    name varchar(50) not null,
    photo text,
    tipo_teams varchar(10) not null,
    id_sports bigint unsigned,
    id_countries bigint unsigned,
    foreign key (id_sports) references sports(id),
    foreign key (id_countries) references countries(id)
);
 
create table players_teams (
    id_players bigint unsigned,
    id_teams bigint unsigned,
    contract_start date not null,
    primary key (id_players,id_teams),
    foreign key (id_players) references players(id),
    foreign key (id_teams) references teams(id)
);
 
create table terminated_contracts(
    id_players bigint unsigned,
    id_teams bigint unsigned,
    contract_end date,
    primary key (id_players,id_teams),
    foreign key (id_players) references players_teams(id_players),
    foreign key (id_teams) references players_teams(id_teams)
);
 
create table extras(
    id serial primary key,
    name varchar(50) not null,
    surname varchar(50) not null,
    photo text,
    rol varchar(50)
);
 
create table extra_compose(
    id_extra bigint unsigned,
    id_teams bigint unsigned,
    contract_start date not null,
    contract_end date,
    primary key (id_extra,id_teams),
    foreign key (id_extra) references extras(id),
    foreign key (id_teams) references teams(id)
);
 
create table events_teams(
    id_teams bigint unsigned,
    id_events bigint unsigned,
    primary key (id_teams,id_events),
    foreign key (id_teams) references teams(id),
    foreign key (id_events) references events(id)
);
 
create table leagues(
    id serial primary key,
    name varchar(50) not null,
    details text not null,
    photo text
);
 
create table leagues_events(
    id_events bigint unsigned,
    id_leagues bigint unsigned,
    primary key (id_events,id_leagues),
    foreign key (id_events) references events(id),
    foreign key (id_leagues) references leagues(id)
);
 
create table leagues_countries(
    id_countries bigint unsigned,
    id_leagues bigint unsigned,
    primary key (id_countries,id_leagues),
    foreign key (id_countries) references countries(id),
    foreign key (id_leagues) references leagues(id)
);
 
create table sanctions(
    id serial,
    id_events bigint unsigned,
    sancion varchar(50) not null,
    primary key (id,id_events),
    foreign key (id_events) references events(id)
);
 
create table sanctions_players(
    id_sancion bigint unsigned,
    id_players bigint unsigned,
    dates date not null,
    primary key (id_sancion,id_players),
    foreign key (id_sancion) references sanctions(id),
    foreign key (id_players) references players(id)
);
 
create table sanctions_extra(
    id_sancion bigint unsigned,
    id_extra bigint unsigned,
    dates date not null,
    primary key (id_sancion,id_extra),
    foreign key (id_sancion) references sanctions(id),
    foreign key (id_extra) references extras(id)
);
 
create table referee(
    id serial primary key,
    name varchar(50) not null,
    surname varchar(50) not null,
    photo text
);
 
create table referee_events(
    id_referee bigint unsigned,
    id_events bigint unsigned,
    dates date not null,
    primary key (id_referee,id_events),
    foreign key (id_events) references events(id),
    foreign key (id_referee) references referee(id)
);
 
create table users_data(
    id serial primary key,
    name varchar(255) not null,
    credit_card varchar(16),
    photo text,
    points bigint not null,
    type_of_user varchar(6),
    total_points bigint unsigned,
    created_at timestamp null default null,
    updated_at timestamp null default null
);
 
create table users(
    id bigint unsigned primary key,
    name varchar(255) not null,
    email varchar(255) not null,
    email_verified_at timestamp null default null,
    password varchar(255) not null,
    remember_token varchar(255) default null,
    created_at timestamp null default null,
    updated_at timestamp null default null,
    foreign key (id) references users_data(id)
);
 
create table post(
    id serial,
    post text not null,
    id_users_data bigint unsigned,
    dates date not null,
    number_of_likes bigint,
    id_events bigint unsigned,
    primary key (id, id_users_data,id_events),
    foreign key (id_users_data) references users_data(id),
    foreign key (id_events) references events(id)
);
create table user_likes(
    id_post bigint unsigned,
    id_users_data bigint unsigned,
    primary key (id_post, id_users_data),
    foreign key (id_post) references post(id),
    foreign key (id_users_data) references users_data(id)
);
 
create table comments (
    id serial,
    comments text,
    id_post bigint unsigned,
    id_users_data bigint unsigned,
    dates date,
    is_child tinyint(1),
    primary key (id,id_post,id_users_data),
    foreign key (id_post) references post(id),
    foreign key (id_users_data) references users_data(id)
);
 
create table comments_parent(
    id_comments_parent bigint unsigned,
    id_comments_child bigint unsigned,
    primary key (id_comments_parent,id_comments_child),
    foreign key (id_comments_parent) references comments(id),
    foreign key (id_comments_child) references comments(id)
);
 
create table reward(
    id serial,
    reward varchar(50),
    id_users_data bigint unsigned,
    date_of_delivery date,
    primary key (id,id_users_data),
    foreign key (id_users_data) references users_data(id)
);
 
create table premium_league(
    id_users_data bigint unsigned,
    id_leagues bigint unsigned,
    primary key (id_users_data,id_leagues),
    foreign key (id_users_data) references users_data(id),
    foreign key (id_leagues) references leagues(id)
);
 
create table premium_sports(
    id_users_data bigint unsigned,
    id_sports bigint unsigned,
    primary key (id_users_data,id_sports),
    foreign key (id_users_data) references users_data(id),
    foreign key (id_sports) references sports(id)
);
 
create table premium_events(
    id_users_data bigint unsigned,
    id_events bigint unsigned,
    primary key (id_users_data,id_events),
    foreign key (id_users_data) references users_data(id),
    foreign key (id_events) references events(id)
);
 
create table premium_teams(
    id_users_data bigint unsigned,
    id_teams bigint unsigned,
    primary key (id_users_data,id_teams),
    foreign key (id_users_data) references users_data(id),
    foreign key (id_teams) references teams(id)
);
 
create table favourite_user(
    id_users_data bigint unsigned,
    id_teams bigint unsigned,
    primary key (id_users_data,id_teams),
    foreign key (id_users_data) references users_data(id),
    foreign key (id_teams) references teams(id)
);
 
create table results(
    id serial,
    tipo_results varchar(11),
    results varchar(25),
    id_events bigint unsigned,
    primary key (id,id_events),
    foreign key (id_events) references events(id)
);
 
create table bets(
    id serial,
    amount int unsigned,
    id_users_data bigint unsigned not null,
    id_events bigint unsigned,
    id_teams bigint unsigned,
    dates date,
    primary key (id,id_users_data,id_events,id_teams),
    foreign key (id_users_data) references users_data(id),
    foreign key (id_teams) references teams(id),
    foreign key (id_events) references events(id)
);
 
create table points_sets(
    number_set tinyint,
    points_set int,
    id_teams bigint unsigned,
    id_results bigint unsigned,
    primary key (id_teams,id_results,number_set),
    foreign key (id_teams) references teams(id),
    foreign key (id_results) references results(id)
);
 
create table results_points(
    id_results bigint unsigned,
    id_teams bigint unsigned,
    point int,
    id_players bigint unsigned,
    primary key (id_results,id_teams,id_players),
    foreign key (id_results) references results(id),
    foreign key (id_teams) references teams(id),
    foreign key (id_players) references players(id)
);
 
create table results_upward(
    id_results bigint unsigned,
    id_teams bigint unsigned,
    position  int,
    result time,
    primary key (id_results,id_teams),
    foreign key (id_results) references results(id),
    foreign key (id_teams) references teams(id)
);
 
create table results_downward(
    id_results bigint unsigned,
    id_teams bigint unsigned,
    position  int,
    result time,
    primary key (id_results,id_teams),
    foreign key (id_results) references results(id),
    foreign key (id_teams) references teams(id)
);
 
create table ads(
    id serial,
    view_counter bigint,
    views_hired bigint,
    url text,
    image text,
    size varchar(10),
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    primary key (id)
);
create table ad_tags(
    id serial,
    ad_id bigint unsigned,
    tag varchar(50),
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    primary key (id),
    foreign key (ad_id) references ads(id)
);

