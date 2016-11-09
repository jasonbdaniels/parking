# Nearby

API end point used get nearby parking spots.

## Protocol

### Method

GET

### Required Parameters

- `lat`: The latitude to use in the center search coordinate.
- `lng`: The longitude to use in the center search coordinate.

### Optional Parameters

- `detail`: Used to retreive extra information about near by parking spots. Set this paramter to the value `1`. Extra info includes:
  - `total_spots`
  - `available_spots`

## Example

```
curl http://domain/parking/api/nearby/?lat=39.0991&lng=-84.5127&detail=1

{
	"valid": 1,
	"message": "Nearby parking spots, sorted by best available.",
	"nearby": [{
		"id": 5,
		"name": "New Parking Name",
		"latitude": 39.0990982056,
		"longitude": -84.5127029419,
		"total_spots": 25,
		"available_spots": 25
	}]
}
```

`total_spots` and `available_spots` are only returend with the `detail` parameter.
