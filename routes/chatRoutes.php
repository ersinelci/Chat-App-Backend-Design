<?php

use controllers\ChatController;


return function ($app) {
    // Import classes

    // Get the database connection from the Slim container
    $db = $app->getContainer()->get('db');

    // Create a new instance of the ChatController with the database connection
    $chatController = new ChatController($db);

    // Base route
    $app->GET('/',[$chatController,'getHomePage']);
    // Create a new chat group
    $app->POST('/chat', [$chatController, 'createChatGroup']);

    // Get all chat groups
    $app->GET('/chat', [$chatController, 'getAllChatGroups']);

    // Get messages for a specific chat group
    $app->GET('/chat/{groupId}', [$chatController, 'getGroupMessages']);

    // Create a new message for a chat group
    $app->POST('/chat/{groupId}', [$chatController, 'createMessage']);

};
