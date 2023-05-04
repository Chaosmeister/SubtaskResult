<?php

namespace Kanboard\Plugin\SubtaskResult\Schema;

use PDO;

const VERSION = 1;

function version_1(PDO $pdo)
{
    $pdo->exec("
        CREATE TABLE subtaskResult (
            id INTEGER,
            'text' TEXT,
            CONSTRAINT subtaskResult FOREIGN KEY (id) REFERENCES subtasks(id) ON DELETE CASCADE
        );
    ");
}
