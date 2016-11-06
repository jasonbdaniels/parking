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

### Response

The response is a JSON object formatted as follows:

```
{
  "parking_places": [
    {
      "id": <number>,
			"name": <string>,
			"latitude": <number>,
			"longitude": <number>,
			"total_spots": <number>,
			"available_spots": <number>,
    }
  ]
}
```

`total_spots` and `available_spots` are only returend with the `detail` parameter.
