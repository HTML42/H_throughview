<?php include '../lib/bootstrap.php'; ?>

<h1>View log-data</h1>
<?php if (!isset($_GET['type']) && !isset($_GET['key'])) { ?>
    <h2>Users</h2>
    <?php foreach (Tracking::list_instances('users') as $user) { ?>
        <a href="logs.php?type=users&key=<?= $user ?>">User #<?= $user ?></a><br/>
    <?php } ?>
    <h2>Websites</h2>
    <?php foreach (Tracking::list_instances('websites') as $website) { ?>
        <a href="logs.php?type=websites&key=<?= $website ?>"><?= $website ?></a><br/>
    <?php } ?>
<?php } else { ?>
    <h2>Tracking (Type: <?= $_GET['type'] ?> | Key: <?= $_GET['key'] ?>)</h2>
    <?php $tracking_folder = DIR_DATA . $_GET['type'] . '/' . $_GET['key'] . '/'; ?>
    <?php foreach (scandir($tracking_folder) as $filename) { ?>
        <?php if (strstr($filename, '.json.zip')) { ?>
            <?php $tracking_content = _zip_read($tracking_folder . $filename); ?>
            <div>File: <?= $filename ?></div>
            <pre><?php var_dump($tracking_content) ?></pre>
        <?php } ?>
    <?php } ?>
<?php } ?>
