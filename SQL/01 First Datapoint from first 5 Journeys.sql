-- Select the first datapoint from the 5 most recent journeys 
SELECT tempdata.journey_id as Journey, DATE_FORMAT(tempdata.point_timestamp,'%D %M %Y') as FirstTimestamp
FROM (SELECT * FROM datapoints WHERE point_id=1) as tempdata
JOIN (SELECT journey_id
	FROM journeys
	ORDER BY journey_id desc
	LIMIT 5) as tempjour ON tempjour.journey_id=tempdata.journey_id
ORDER BY tempdata.journey_id desc
;