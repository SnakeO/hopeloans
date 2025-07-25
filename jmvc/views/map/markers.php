/*
 * For performance reasons, you should provide all marker locations via GPS coordinates (latitude / longitude), instead of using postal addresses.
 *
 * Coordinates can be used by the map immediately, while addresses have to be geocoded first, in order to obtain the matching coordinates.
 *
 * Google imposes limits as to how many geocode requests can be sent at a time and also sets a daily limit. So use addresses, if necessary, only for few markers.
 *
 * Do NOT change the Callback Name "GoogleMapsPlusMarkerImport" as it is required!
 *
 * The following parameter are required for each marker: 'title' AND 'latitude' + 'longitude' (if using coordinates) or 'address'
*/

GoogleMapsPlusMarkerImport(
	{
		'markers': <?=json_encode($markers)?>
	}
);