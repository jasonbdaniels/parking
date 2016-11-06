# Get Info

API end point used to get information about available parking spots.

## Protocol

### Method

GET

### Required Parameters

- `parkplaceid` Id of the parking place.

## Response

Response is a JSON Object formated as follows:

```
{
  "info": {
    "spots": <number>,
    "available_spots": <number>
  }
}
```
