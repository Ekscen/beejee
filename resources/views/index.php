<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TestTask</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css?<?=time()?>">
</head>
<body>
    <div class="container">
        <section id="auth" class="my-3 row">
            <div class="col"></div>
            <form class="col-12 col-sm-10 col-md-8 col-lg-4">
                <div class="form-group">
                    <label for="InputLogin">Логин</label>
                    <input type="email" class="form-control" id="InputLogin" placeholder="Введите логин">
                </div>
                <div class="form-group">
                    <label for="InputPassword">Пароль</label>
                    <input type="password" class="form-control" id="InputPassword" placeholder="Пароль">
                </div>
                <div class="w-100 text-center">
                    <button type="submit" class="btn btn-primary">Войти</button>
                </div>
            </form>
            <div class="col"></div>
            <!-- <div class="col"></div>
            <form class="col-12 col-sm-10 col-md-8 col-lg-4">
                <div class="w-100 text-center">
                    <button type="submit" class="btn btn-danger">Выйти</button>
                </div>
            </form>
            <div class="col"></div> -->
        </section>
        <section id="table-task" class="my-3 row">
            <?= isset($data['success']) ? "<div class='alert alert-success w-100' role='alert'>{$data['success']}</div>" : ""?>
            <table class="table table-responsive w-100 d-block d-md-table">
                <thead class="thead-dark">
                    <tr>
                    <th scope="col">Имя пользователя</th>
                    <th scope="col">Email</th>
                    <th scope="col">Текст задачи</th>
                    <th scope="col">Статус</th>
                    </tr>
                </thead>
                <tbody>
                    <? foreach ($data["tasks"] as $task): ?>
                    <tr>
                        <td><?=$task['name']?></td>
                        <td><?=$task['email']?></td>
                        <td><?=$task['task']?></td>
                        <td><?=$task['status']?></td>
                    </tr>
                    <? endforeach;?>
                    <form action="\putTask" method="POST">
                        <tr>
                            <td>
                                <input type="text" name="name" value="<?= isset($data['formData']['name']) ? $data['formData']['name'] : ""?>">
                                <?= isset($data['errors']['name']) ? "<div class='text-danger'>{$data['errors']['name']}</div>" : ""?>
                            </td>
                            <td>
                                <input type="email" name="email" value="<?= isset($data['formData']['email']) ? $data['formData']['email'] : ""?>">
                                <?= isset($data['errors']['email']) ? "<div class='text-danger'>{$data['errors']['email']}</div>" : ""?>
                            </td>
                            <td>
                                <input type="text" name="task" value="<?= isset($data['formData']['task']) ? $data['formData']['task'] : ""?>">
                                <?= isset($data['errors']['task']) ? "<div class='text-danger'>{$data['errors']['task']}</div>" : ""?>
                            </td>
                            <td><button type="submit" class="btn btn-primary">Опубликовать</button></td>
                        </tr>
                    </form>
                </tbody>
            </table>
        </section>
        <section id="nav">
            <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
                </li>
            </ul>
            </nav>
        </section>
    </div>
</body>
</html>