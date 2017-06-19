## 1.0.6
 * Bugfix post url for property number search widget
 * Changes to state filter

## 1.0.5
 * Bugfix pagination parameter
 * Bugfix post url for search widget

## 1.0.4
 * Add support for regionalized number and currency formatting

## 1.0.3
 * Update german translations

## 1.0.2
 * Fix SDK default curl options getting overwritten by Wordpress plugin

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
 * Add Google API key field in admin panel.
 * Add new ordering parameters to realty list shortcode.
 * Fix unescaped realty title in realty js object needed for Google Maps.
 * Add Open Graph meta tags for realty and project detail pages.
 * Update translations

## 1.0.0
 * Initial release 
