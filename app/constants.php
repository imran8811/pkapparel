<?php

define ('metaData', [
  "" => [
    "title" => "Garments Manufacturer Wholesaler and Exporter",
    "keywords" => "t shirts factory manufacturer, hoodie making, jeans supplier",
    "description" => ""
  ],
  "about" => [
    "title" => "About Us - Garments manufacturer and Wholesaler",
    "keywords" => "t shirts factory manufacturer, hoodie making, jeans supplier",
    "description" => ""
  ],
  "contact" => [
    "title" => "Contact Us - Garments manufacturer and Wholesaler",
    "keywords" => "t shirts factory manufacturer, hoodie making, jeans supplier",
    "description" => ""
  ],
  "factory" => [
    "title" => "Factory Visit - Garments manufacturer and Wholesaler",
    "keywords" => "t shirts factory manufacturer, hoodie making, jeans supplier",
    "description" => ""
  ],
  "blog" => [
    "title" => "Blog - Garments manufacturer and Wholesaler",
    "keywords" => "t shirts factory manufacturer, hoodie making, jeans supplier",
    "description" => ""
  ],
  "shop" => [
    "title" => "Garments Wholesale Shop for men women boys and girls",
    "keywords" => "t shirts factory manufacturer, hoodie making, jeans supplier",
    "description" => "Garments Wholesale Shop for men women boys and girls"
  ],
  "men" => [
    "title" => "Men Garments Jeans Pants Jackets Tshirts Hoodies Cargo Trousers",
    "keywords" => "t shirts factory manufacturer, hoodie making, jeans supplier",
    "description" => "Men Garments Jeans Pants Jackets Tshirts Hoodies Cargo Trousers"
  ],
  "jeans-pant" => [
    "title" => "Men Garments Jeans Pants Jackets Tshirts Hoodies Cargo Trousers",
    "keywords" => "t shirts factory manufacturer, hoodie making, jeans supplier",
    "description" => "Men Garments Jeans Pants Jackets Tshirts Hoodies Cargo Trousers"
  ],
  "chino-pant" => [
    "title" => "Men Garments Jeans Pants Jackets Tshirts Hoodies Cargo Trousers",
    "keywords" => "t shirts factory manufacturer, hoodie making, jeans supplier",
    "description" => "Men Garments Jeans Pants Jackets Tshirts Hoodies Cargo Trousers"
  ],
  "women" => [
    "title" => "Women Garments Jeans Pants Jackets Tshirts Hoodies Cargo Trousers",
    "keywords" => "t shirts factory manufacturer, hoodie making, jeans supplier",
    "description" => "Women Garments Jeans Pants Jackets Tshirts Hoodies Cargo Trousers"
  ],
  "boys" => [
    "title" => "Boys Garments Jeans Pants Jackets Tshirts Hoodies Cargo Trousers",
    "keywords" => "t shirts factory manufacturer, hoodie making, jeans supplier",
    "description" => "Boys Garments Jeans Pants Jackets Tshirts Hoodies Cargo Trousers"
  ],
  "girls" => [
    "title" => "Girls Garments Jeans Pants Jackets Tshirts Hoodies Cargo Trousers",
    "keywords" => "t shirts factory manufacturer, hoodie making, jeans supplier",
    "description" => "Girls Garments Jeans Pants Jackets Tshirts Hoodies Cargo Trousers"
  ],
  "bulk-jeans" => [
    "title" => "Bulk Jeans",
    "keywords" => "t shirts factory manufacturer, hoodie making, jeans supplier",
    "description" => ""
  ],
  "jeans-manufacturers" => [
    "title" => "Jeans Manufacturers",
    "keywords" => "t shirts factory manufacturer, hoodie making, jeans supplier",
    "description" => ""
  ],
  "jeans-manufacturing-cost" => [
    "title" => "Jeans Manufacturing Cost",
    "keywords" => "t shirts factory manufacturer, hoodie making, jeans supplier",
    "description" => "Good quality jeans manufacturing cost is between $3.5 to $5.2, depending on the material, sizes, styling and washing affects. Learn how material sourcing, production scale, and geographic location impact pricing."
  ],
  "jeans-pants-manufacturers" => [
    "title" => "Jeans Pants Manufacturers",
    "keywords" => "t shirts factory manufacturer, hoodie making, jeans supplier",
    "description" => ""
  ],
  "jeans-wholesale" => [
    "title" => "Jeans Wholesale",
    "keywords" => "t shirts factory manufacturer, hoodie making, jeans supplier",
    "description" => ""
  ],
  "motorcycle-jeans-manufacturers" => [
    "title" => "Motorcycle Jeans Manufacturers",
    "keywords" => "t shirts factory manufacturer, hoodie making, jeans supplier",
    "description" => ""
  ],
  "wholesale-denim-jeans-suppliers" => [
    "title" => "Wholesale Denim Jeans Suppliers",
    "keywords" => "t shirts factory manufacturer, hoodie making, jeans supplier",
    "description" => ""
  ],
  "wholesale-jeans-bulk" => [
    "title" => "Wholesale Jeans Bulk",
    "keywords" => "t shirts factory manufacturer, hoodie making, jeans supplier",
    "description" => ""
  ],
  "wholesale-jeans-manufacturers" => [
    "title" => "Wholesale Jeans Manufacturers",
    "keywords" => "t shirts factory manufacturer, hoodie making, jeans supplier",
    "description" => ""
  ],
  "wholesale-jeans-suppliers" => [
    "title" => "Wholesale Jeans suppliers",
    "keywords" => "t shirts factory manufacturer, hoodie making, jeans supplier",
    "description" => ""
  ],
  "wholesale-women-jeans" => [
    "title" => "Wholesale Women Jeans",
    "keywords" => "t shirts factory manufacturer, hoodie making, jeans supplier",
    "description" => ""
  ],
  "jeans-manufacturers-in-pakistan" => [
    "title" => "Jeans Manufacturers in Pakistan",
    "keywords" => "jeans manufacturers in pakistan, list of jeans manufacturers in pakistan, top jeans manufacturers in pakistan",
    "description" => ""
  ],
]);

function user_info($ip = NULL, $purpose = "location", $deep_detect = TRUE){
  $output = NULL;
  if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
    $ip = $_SERVER["REMOTE_ADDR"];
    if ($deep_detect) {
      if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
      if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
  }
  $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), "", strtolower(trim($purpose)));
  $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
  $continents = array(
    "AF" => "Africa",
    "AN" => "Antarctica",
    "AS" => "Asia",
    "EU" => "Europe",
    "OC" => "Australia (Oceania)",
    "NA" => "North America",
    "SA" => "South America"
  );
  if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
    $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
    if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
      switch ($purpose) {
        case "location":
          $output = array(
            "city"           => @$ipdat->geoplugin_city,
            "state"          => @$ipdat->geoplugin_regionName,
            "country"        => @$ipdat->geoplugin_countryName,
            "country_code"   => @$ipdat->geoplugin_countryCode,
            "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
            "continent_code" => @$ipdat->geoplugin_continentCode
          );
          break;
        case "address":
          $address = array($ipdat->geoplugin_countryName);
          if (@strlen($ipdat->geoplugin_regionName) >= 1)
            $address[] = $ipdat->geoplugin_regionName;
          if (@strlen($ipdat->geoplugin_city) >= 1)
            $address[] = $ipdat->geoplugin_city;
          $output = implode(", ", array_reverse($address));
          break;
        case "city":
          $output = @$ipdat->geoplugin_city;
          break;
        case "state":
          $output = @$ipdat->geoplugin_regionName;
          break;
        case "region":
          $output = @$ipdat->geoplugin_regionName;
          break;
        case "country":
          $output = @$ipdat->geoplugin_countryName;
          break;
        case "countrycode":
          $output = @$ipdat->geoplugin_countryCode;
          break;
      }
    }
  }
  return $output;
}
$userCountry = user_info("Visitor", "Country");
$bannedCountries = ["Pakistan", "India", "China", "Vietnam", "Bangladesh", "Nepal", "Sri Lanka"];
define('userCountry', $userCountry);
define('bannedCountries', $bannedCountries);
if($userCountry === 'Pakistan'){
  define('defaultCurrency', "Rs");
} else {
  define('defaultCurrency', "$");
}

return [
  metaData,
  userCountry,
  bannedCountries,
  defaultCurrency
]

?>
