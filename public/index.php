<?php
/**
 * This is a very simple MVC set up done from scratch, I have skipped over a lot
 * of smart features trying to keep the task on point. Were I actually making a
 * routing system I probably wouldn't call the controller 'SearchController', and
 * would also take into account the HTTP method used in talking to the system.
 */
require('../SearchController.php');

$route = $_GET['route'] ?? 'searchPage';

$validRoutes = [
    'searchPage',
    'searchNames',
];

if (in_array($route, $validRoutes)) {
    $searchController = new SearchController();
    $searchController->{$route}();
}

die;

/**
 * Generate a sequence of ToucanTech, starting at 1 increment until we have reached the passed length
 * (defaults to 100), if the number is a multiple of 3 we print "Toucan", if the number is a multiple
 * of 5 we print “Tech", if the number is a multiple of both we print “ToucanTech".
 *
 * Can also pass in a separator to specify how the code should be presented on screen
 *
 * @param int $length - defaults to 100
 * @param string $separator - defaults to <br>
 * @return void
 */
function toucanTech(int $length = 100, string $separator = "<br>") : void {
    for ($count = 1; $count <= $length; $count++) {
        $string = "";
        // Multiple of 3 gets Toucan
        if ($count % 3 == 0) {
            $string .= "Toucan";
        }

        // Multiple of 5 gets Tech, if its a multiple of 3 & 5 the Toucan will be combined with Tech here
        if ($count % 5 == 0) {
            $string .= "Tech";
        }

        echo ($string ?: $count) . $separator;
    }
}
toucanTech();
