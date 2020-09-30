<?php

$routes = [
    'Task' => [ // Controller
    	['home', '/', 'GET'], // action, url, method
        ['index', '/api/tasks', 'GET'], // action, url, method
        ['store', '/api/tasks', 'POST'], // action, url, method
        ['destroy', '/api/tasks/{id:\d+}', 'DELETE'], // action, url, method
        ['update', '/api/tasks/{id:\d+}', 'PATCH'], // action, url, method
        ['markAsDone', '/api/tasks/markasdone/{id:\d+}', 'PATCH'], // action, url, method

    ],
];
