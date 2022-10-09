create database metaberrystudios;
use metaberrystudios;
create table sports(
    id serial primary key,
    name varchar(50) not null,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    deleted_at timestamp null default null,
    photo text not null
);  
 
create table countries(
    id serial primary key,
    name varchar(50) not null,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    deleted_at timestamp null default null,
    photo text not null
);
 
create table players(
    id serial primary key,
    name varchar(50) not null,
    surname varchar(50) not null,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    deleted_at timestamp null default null,
    photo text not null
);
 
create table events(
    id serial primary key,
    name varchar(50) not null,
    details text not null,
    id_sports bigint unsigned not null,
    id_countries bigint unsigned not null,
    dates date not null,
    relevance tinyint not null,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    deleted_at timestamp null default null,
    foreign key (id_sports) references sports(id),
    foreign key (id_countries) references countries(id)
);
 
create table teams (
    id serial primary key,
    name varchar(50) not null,
    photo text not null,
    tipo_teams varchar(10) not null,
    id_sports bigint unsigned not null,
    id_countries bigint unsigned not null,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    deleted_at timestamp null default null,
    foreign key (id_sports) references sports(id),
    foreign key (id_countries) references countries(id)
);
 
create table players_teams (
    id serial primary key,
    id_players bigint unsigned not null,
    id_teams bigint unsigned not null,
    contract_start date not null,
    contract_end date not null,
    status varchar(10) not null,
    foreign key (id_players) references players(id),
    foreign key (id_teams) references teams(id)
);
 
create table terminated_contracts(
    id_players bigint unsigned not null,
    id_teams bigint unsigned not null,
    contract_end date not null,
    primary key (id_players,id_teams),
    foreign key (id_players, id_teams) references players_teams(id_players, id_teams)
);
 
create table extras(
    id serial primary key,
    name varchar(50) not null,
    surname varchar(50) not null,
    photo text not null,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    deleted_at timestamp null default null,
    rol varchar(50) not null
);
 
create table extra_compose(
    id_extra bigint unsigned not null,
    id_teams bigint unsigned not null,
    contract_start date not null,
    contract_end date not null,
    primary key (id_extra,id_teams),
    foreign key (id_extra) references extras(id),
    foreign key (id_teams) references teams(id)
);
 
create table events_teams(
    id_teams bigint unsigned not null,
    id_events bigint unsigned not null,
    primary key (id_teams,id_events),
    foreign key (id_teams) references teams(id),
    foreign key (id_events) references events(id)
);
 
create table leagues(
    id serial primary key,
    name varchar(50) not null,
    details text not null,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    deleted_at timestamp null default null,
    photo text not null
);
 
create table leagues_events(
    id_events bigint unsigned not null,
    id_leagues bigint unsigned not null,
    primary key (id_events,id_leagues),
    foreign key (id_events) references events(id),
    foreign key (id_leagues) references leagues(id)
);
 
create table leagues_countries(
    id_countries bigint unsigned not null,
    id_leagues bigint unsigned not null,
    primary key (id_countries,id_leagues),
    foreign key (id_countries) references countries(id),
    foreign key (id_leagues) references leagues(id)
);
 
create table sanctions(
    id serial,
    id_events bigint unsigned not null,
    sancion varchar(50) not null,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    deleted_at timestamp null default null,
    primary key (id,id_events),
    foreign key (id_events) references events(id)
);
 
create table sanctions_players(
    id_sancion bigint unsigned not null,
    id_players bigint unsigned not null,
    dates date not null,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    deleted_at timestamp null default null,
    primary key (id_sancion,id_players),
    foreign key (id_sancion) references sanctions(id),
    foreign key (id_players) references players(id)
);
 
create table sanctions_extra(
    id_sancion bigint unsigned not null,
    id_extra bigint unsigned not null,
    dates date not null,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    deleted_at timestamp null default null,
    primary key (id_sancion,id_extra),
    foreign key (id_sancion) references sanctions(id),
    foreign key (id_extra) references extras(id)
);
 
create table referee(
    id serial primary key,
    name varchar(50) not null,
    surname varchar(50) not null,
    photo text,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    deleted_at timestamp null default null
);
 
create table referee_events(
    id_referee bigint unsigned not null,
    id_events bigint unsigned not null,
    dates date not null,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    deleted_at timestamp null default null,
    primary key (id_referee,id_events),
    foreign key (id_events) references events(id),
    foreign key (id_referee) references referee(id)
);
 
create table users_data(
    id serial primary key,
    name varchar(255) not null,
    credit_card varchar(16) not null,
    photo text not null,
    points bigint not null,
    type_of_user varchar(6) not null,
    total_points bigint unsigned not null,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    deleted_at timestamp null default null
);
 
create table users(
    id bigint unsigned primary key,
    name varchar(255) not null,
    email varchar(255) not null,
    email_verified_at timestamp null default null,
    password varchar(255) not null,
    remember_token varchar(255) default null,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    deleted_at timestamp null default null,
    foreign key (id) references users_data(id)
);
 
create table post(
    id serial,
    post text not null,
    id_users_data bigint unsigned not null,
    dates date not null,
    number_of_likes bigint not null,
    id_events bigint unsigned not null,
    primary key (id, id_users_data,id_events),
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    deleted_at timestamp null default null,
    foreign key (id_users_data) references users_data(id),
    foreign key (id_events) references events(id)
);
create table user_likes(
    id_post bigint unsigned not null,
    id_users_data bigint unsigned not null,
    primary key (id_post, id_users_data),
    foreign key (id_post) references post(id),
    foreign key (id_users_data) references users_data(id)
);
 
create table comments (
    id serial,
    comments text not null,
    id_post bigint unsigned not null,
    id_users_data bigint unsigned not null,
    dates date not null,
    is_child tinyint(1) not null,
    primary key (id,id_post,id_users_data),
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    deleted_at timestamp null default null,
    foreign key (id_post) references post(id),
    foreign key (id_users_data) references users_data(id)
);
 
create table comments_parent(
    id_comments_parent bigint unsigned not null,
    id_comments_child bigint unsigned not null,
    primary key (id_comments_parent,id_comments_child),
    foreign key (id_comments_parent) references comments(id),
    foreign key (id_comments_child) references comments(id)
);
 
create table reward(
    id serial,
    reward varchar(50) not null,
    id_users_data bigint unsigned not null,
    date_of_delivery date not null,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    deleted_at timestamp null default null,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    deleted_at timestamp null default null,
    primary key (id,id_users_data),
    foreign key (id_users_data) references users_data(id)
);
 
create table premium_league(
    id_users_data bigint unsigned not null,
    id_leagues bigint unsigned not null,
    primary key (id_users_data,id_leagues),
    foreign key (id_users_data) references users_data(id),
    foreign key (id_leagues) references leagues(id)
);
 
create table premium_sports(
    id_users_data bigint unsigned not null,
    id_sports bigint unsigned not null,
    primary key (id_users_data,id_sports),
    foreign key (id_users_data) references users_data(id),
    foreign key (id_sports) references sports(id)
);
 
create table premium_events(
    id_users_data bigint unsigned not null,
    id_events bigint unsigned not null,
    primary key (id_users_data,id_events),
    foreign key (id_users_data) references users_data(id),
    foreign key (id_events) references events(id)
);
 
create table premium_teams(
    id_users_data bigint unsigned not null,
    id_teams bigint unsigned not null,
    primary key (id_users_data,id_teams),
    foreign key (id_users_data) references users_data(id),
    foreign key (id_teams) references teams(id)
);
 
create table favourite_user(
    id_users_data bigint unsigned not null,
    id_teams bigint unsigned not null,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    deleted_at timestamp null default null,
    primary key (id_users_data,id_teams),
    foreign key (id_users_data) references users_data(id),
    foreign key (id_teams) references teams(id)
);
 
create table results(
    id serial,
    tipo_results varchar(11) not null,
    results varchar(25) not null,
    id_events bigint unsigned not null,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    deleted_at timestamp null default null,
    primary key (id,id_events),
    foreign key (id_events) references events(id)
);
 
create table bets(
    id serial,
    amount int unsigned not null,
    id_users_data bigint unsigned not null,
    id_events bigint unsigned not null,
    id_teams bigint unsigned not null,
    dates date not null,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    deleted_at timestamp null default null,
    primary key (id,id_users_data,id_events,id_teams),
    foreign key (id_users_data) references users_data(id),
    foreign key (id_teams) references teams(id),
    foreign key (id_events) references events(id)
);
 
create table points_sets(
    number_set tinyint not null,
    points_set int not null,
    id_teams bigint unsigned not null,
    id_results bigint unsigned not null,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    deleted_at timestamp null default null,
    primary key (id_teams,id_results,number_set),
    foreign key (id_teams) references teams(id),
    foreign key (id_results) references results(id)
);
 
create table results_points(
    id_results bigint unsigned not null,
    id_teams bigint unsigned not null,
    point int not null,
    id_players bigint unsigned not null,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    deleted_at timestamp null default null,
    primary key (id_results,id_teams,id_players),
    foreign key (id_results) references results(id),
    foreign key (id_teams) references teams(id),
    foreign key (id_players) references players(id)
);
 
create table results_upward(
    id_results bigint unsigned not null,
    id_teams bigint unsigned not null,
    position int not null,
    result time not null,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    deleted_at timestamp null default null,
    primary key (id_results,id_teams),
    foreign key (id_results) references results(id),
    foreign key (id_teams) references teams(id)
);
 
create table results_downward(
    id_results bigint unsigned not null,
    id_teams bigint unsigned not null,
    position int not null,
    result time not null,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    deleted_at timestamp null default null,
    primary key (id_results,id_teams),
    foreign key (id_results) references results(id),
    foreign key (id_teams) references teams(id)
);
 
create table ads(
    id serial,
    view_counter bigint not null,
    views_hired bigint not null,
    url text not null,
    image text not null,
    size varchar(10) not null,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    deleted_at timestamp null default null,
    primary key (id)
);

create table tags(
    id serial,
    tag text not null,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    deleted_at timestamp null default null,
    primary key (id)
);

create table ad_tags(
    id_tag bigint unsigned not null,
    id_ad bigint unsigned not null,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP,
    deleted_at timestamp null default null,
    primary key (id_tag, id_ad),
    foreign key (id_ad) references ads(id),
    foreign key (id_tag) references tags(id)
);

