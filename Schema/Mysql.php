<?php

namespace Kanboard\Plugin\SubtaskResult\Schema;

use PDO;

const VERSION = 2;

function version_1(PDO $pdo)
{
    $pdo->exec("
        CREATE TABLE subtaskResult (
            id INT,
            'text' TEXT,
            CONSTRAINT subtaskResult FOREIGN KEY (id) REFERENCES subtasks(id) ON DELETE CASCADE
        );
    ");
}

function version_2(PDO $pdo)
{
    $pdo->exec("ALTER TABLE subtaskResult RENAME TO subtask_result;");
}
