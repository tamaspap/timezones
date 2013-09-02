/**
 * Get timezone data (offset and dst)
 *
 *  Inspired by: http://goo.gl/E41sTi
 *
 * @returns {{offset: number, dst: number}}
 */
function getTimeZoneData() {
	var today = new Date();
  	var jan = new Date(today.getFullYear(), 0, 1);
  	var jul = new Date(today.getFullYear(), 6, 1);
  	var dst = today.getTimezoneOffset() < Math.max(jan.getTimezoneOffset(), jul.getTimezoneOffset());
  
  	return {
    	offset: -today.getTimezoneOffset() / 60,
    	dst: +dst
  	};
}