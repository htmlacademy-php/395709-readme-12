<?php
if (isset($_SESSION['userName'])) {
    ?>
    <main class="page__main page__main--publication">
        <div class="container">
            <?php
            if ($_GET['id'] < 0) {
                header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found', true, 404);
                http_response_code(404);
                header('Location: 404.html');
                exit();
            } else {
                $page_content = include_template($posts[0]['icon_name'].'.php',
                    ['post' => $posts[0], 'con' => $con, 'id' => $id]);
                print($page_content);
            }
            ?>

        </div>
    </main>
<?php } else {
    header("Location:http://395709-readme-12/");
} ?>
