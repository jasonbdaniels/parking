# Parking
API to track open parking spots around town.

# Access Control

Must provide a top level *credentials.php* file with the following variables set:

```
$SQL_HOST = "";
$SQL_USERNAME = "";
$SQL_PASSWORD = "";
$SQL_DATABASE = "";
```

# SQL Schema

The parking API expects there to exist two tables to exist, described as follows.

## parking_place

This table describes a parking place.

| id | name | latitude | longitude |
|----|------|----------|-----------|

## parking_info

This table describes details about the available number of parking spots.

| place_id | spots | available_spots |
|----------|-------|-----------------|
