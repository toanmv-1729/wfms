<?php

return [
    'action' => [
        'staff-read' => 'staff-read',
        'staff-write' => 'staff-write',
        'role-read' => 'role-read',
        'role-write' => 'role-write',
        'project-read' => 'project-read',
        'project-write' => 'project-write',
        'document-read' => 'document-read',
        'document-write' => 'document-write',
        'team-read' => 'team-read',
        'team-write' => 'team-write',
        'version-read' => 'version-read',
        'version-write' => 'version-write',
        'sample-read' => 'sample-read',
        'sample-write' => 'sample-write',
        'ticket-read' => 'ticket-read',
        'ticket-write' => 'ticket-write',
        'history-read' => 'history-read',
        'history-write' => 'history-write',
        'profile-write' => 'profile-write',
    ],
    'default_role_permission' => [
        'scrum_master' => [1, 2, 3, 5, 6, 7, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19],
        'product_owner' => [5, 7, 8, 9, 11, 15, 16, 17, 18, 19],
        'member' => [5, 7, 9, 11, 15, 16, 17, 18, 19],
    ],
];
