<?php
echo var_dump($res);
try {
    switch ($_GET["method"] ?? $_POST["method"] ?? null) {
        case 'create':
            break;
        case 'read':
            break;
        case 'update':
            break;
        case 'delete':
            break;
        default:
            throw new Error('Nem megfelelő paraméterek!');
            break;
    }
} catch (Error $e) {
}
