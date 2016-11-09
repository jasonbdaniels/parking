# Get Info

API end point used to get information about available parking spots.

## Protocol

### Method

GET

### Required Parameters

- `parkplaceid` Id of the parking place.

## Example

```
curl http://domain/parking/api/getinfo/?parkplaceid=5

{
	"valid": 1,
	"message": "Got info.",
	"info": {
		"spots": 25,
		"available_spots": 25
	}
}
```
