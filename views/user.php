<?php include VIEW_PATH."layout/header.php" ?>

<body>
    <div class="container mt-5">
        <div class="w-50 mx-auto">
            <div class="card" style="width: 18rem;">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><?= $user->name ?>
                    </li>
                    <li class="list-group-item"><?= $user->Email ?>
                    </li>
                    <li class="list-group-item"><?= $user->Age ?>
                    </li>
                    <li class="list-group-item"><?= $user->password ?>
                    </li>
                    <a href="/" class="btn btn-link">Back to homepage</a>
                </ul>
            </div>
        </div>


    </div>
    <?php include VIEW_PATH."/layout/footer.php";
