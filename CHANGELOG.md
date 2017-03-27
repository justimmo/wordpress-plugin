## 1.0.1
 * Update search form partial to use realty type 'id' instead of 'key' as value in select input 
 * Update templating class 'enqueueScripts' method to register plugin jQuery library only if isn't registered yet by theme or WordPress
 * Update routing class 'buildPagerUrl' method to use correct full url before appending filter query params
 * Update SearchForm widget to store GET params in variable for form auto-completion usage.
 * Use plugin template locator method to allow search form to be overridden in theme folder.
 * Remove featherlight library in favour of lightbox for admin images.
 * Fix incorrect use of 'filterByZipCode' method.
 * Fix overwritten $cities variable error which prevented the search form from showing autocompleted states.
 * Change state checkboxes to dropdown and restrict zipcodes/cities by previously selected state.
 * Update JUSTIMMO PHP-SDK to 1.1.8

## 1.0.0
 * Initial release 

