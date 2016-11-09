# Enter

API end point used to log entering a garage parking spot.

## Protocol

### Method

POST

### Required Parameters

- `parkplaceid` Id of the parking place.


## Example

```
curl --data parkplaceid=5 http://domain/parking/api/enter/

{"valid":1,"message":"Parking place entered."}
```
