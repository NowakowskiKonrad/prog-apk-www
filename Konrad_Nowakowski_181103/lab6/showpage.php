<?php
declare(strict_types=1);

function PokazPodstrone(PDO $pdo, string$alias): ?array
{
    if (preg_match('/^[a-z0-9-]{1,20}$/',$alias) !== 1) {
        return null;
    }

    $stmt =$pdo->prepare(
        'SELECT id, page_title, page_content FROM page_list WHERE alias = :alias AND status = 1 LIMIT 1'
    );
    $stmt->execute([':alias' =>$alias]);

    $record =$stmt->fetch(PDO::FETCH_ASSOC);

    return $record !== false ? $record : null;
}