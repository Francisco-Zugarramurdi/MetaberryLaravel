SELECT events.name as EventName, teams.name as Teams, teams.photo as TeamPhoto,
events.date as EventDate, results.results as Result
from teams
join events_teams
on teams.id = events_teams.id_teams
join events
on events_teams.id_events = events.id
join results
on results.id_events = events.id
where events.relevance = 5;

SELECT teams.name as FavouriteTeam, teams.photo as TeamPhoto
from teams
join favourite_user
on teams.id = favourite_user.id_teams
join users_data
on users_data.id = favourite_user.id_users_data
where users_data.id = 1;

select users_data.name as UserName, users_data.photo as UserPhoto, post.post as
Post, post.dates as PostDate, post.number_of_likes as Likes
from users_data
join post
on users_data.id = post.id_users_data;

select users_data.photo as UserPhoto,
users_data.name as UserName,
users.email as UserEmail,
users_data.points as CurrentPoints,
users_data.total_points as TotalPoints,
post.post as Post,
post.dates as PostDate,
post.number_of_likes as Likes,
teams.name as FavouriteTeam,
leagues.name as Leagues,
sports.name as Sports,
events.name as EventName,
teams.name as TeamName
from users_data
join users
on users_data.id = users.id
join post
on users_data.id = post.id_users_data
join favourite_user
on users_data.id = favourite_user.id_users_data
join teams
on teams.id = favourite_user.id_teams
join premium_league
on premium_league.id_users_data = users_data.id
join leagues
on leagues.id = premium_league.id_leagues
join premium_sports
on premium_sports.id_users_data = users_data.id
join sports
on sports.id = premium_sports.id_sports
join premium_events
on premium_events.id_users_data = users_data.id
join events
on events.id = premium_events.id_events
join premium_teams
on premium_teams.id_users_data = users_data.id and teams.id =
premium_teams.id_teams
where users_data.id = 1;

SELECT teams.name as TeamName, teams.photo as TeamPhoto, sports.name as Sport
from teams
join sports
on teams.id_sports = sports.id
where teams.id = 1;

SELECT events.name as EventName, teams.name as TeamName, teams.photo as
TeamPhoto, events.date as EventDate, results.results as Result
from teams
join events_teams
on teams.id = events_teams.id_teams
join events
on events_teams.id_events = events.id
join results
on results.id_events = events.id;

SELECT events.name as EventName, teams.name as TeamName, teams.photo as
TeamPhoto, events.date as EventDate, results.results as Result
from teams
join events_teams
on teams.id = events_teams.id_teams
join events
on events_teams.id_events = events.id
join results
on results.id_events = events.id
join countries
on events.id_countries = countries.id
where countries.name like 'Uruguay';