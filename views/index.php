<?php include VIEW_PATH."layout/header.php" ?>

<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-md-4 mt-1 p-5 bg-light">
            <form method="POST" action="/user/save">
                <!-- Username input -->
                <div class="form-outline mb-4">
                    <input name="username" type="text" id="Username" class="form-control" />
                    <label class="form-label" for="Username">Username</label>
                </div>
                <!-- Email input -->
                <div class="form-outline mb-4">
                    <input name="email" type="email" id="form1Example1" class="form-control" />
                    <label class="form-label" for="form1Example1">Email address</label>
                </div>

                <!-- Password input -->
                <div class="form-outline mb-4">
                    <input name="password" type="password" id="form1Example2" class="form-control" />
                    <label class="form-label" for="form1Example2">Password</label>
                </div>
                <!-- Age input -->
                <div class="form-outline mb-4">
                    <input name="age" type="text" id="Age" class="form-control" />
                    <label class="form-label" for="Age">Age</label>
                </div>
                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block">Add user</button>
            </form>
        </div>
        <div class="col-md-8">
            <table class="table">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Age</th>
                        <th scope="col"></th>

                    </tr>
                </thead>
                <tbody>

                    <?php
                         if (!empty($users)):
                            foreach ($users as $user) :
                        ?>
                    <tr>
                        <td>
                            <?= $user->name ?>
                        </td>
                        <td>
                            <?= $user->Email ?>
                        </td>
                        <td>
                            <?= $user->Age ?>
                        </td>
                        <td>
                            <a href="/edit/<?=$user->id?>"
                                class="btn btn-primary btn-floating">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="/delete/<?=$user->id?>"
                                class="btn btn-danger btn-floating ms-3">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                            <a href="/user/<?=$user->id?>"
                                type="button" class="btn btn-info btn-floating ms-3">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    <?php
                            endforeach;
                        else:
                        ?>
                    <td colspan="4"> No user registered </td>

                    <?php endif; ?>

                </tbody>
            </table>
        </div>
    </div>
</div>


<?php include VIEW_PATH."/layout/footer.php";
