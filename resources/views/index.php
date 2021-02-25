<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TestTask</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css?<?=time()?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class="container">
        <section id="auth" class="my-3 row">
            <? if (isset($data['user'])):?>
                <div class="col"></div>
                <form action="\logOut" method="post" class="col-12 col-sm-10 col-md-8 col-lg-4">
                    <div class="w-100 text-center">
                        <button type="submit" name="logOut" class="btn btn-danger">Выйти</button>
                    </div>
                </form>
                <div class="col"></div>
            <? else: ?>
                <div class="col"></div>
                <form action="\logIn" method="post" class="col-12 col-sm-10 col-md-8 col-lg-4">
                    <div class="form-group">
                        <label for="InputLogin">Логин</label>
                        <input type="text" name="login" required class="form-control" id="InputLogin" placeholder="Введите логин">
                    </div>
                    <div class="form-group">
                        <label for="InputPassword">Пароль</label>
                        <input type="password" name="password" required class="form-control" id="InputPassword" placeholder="Пароль">
                    </div>
                    <? if (isset($data['loginError'])) : ?>
                        <div class='alert alert-danger w-100' role='alert'><?=$data['loginError']?></div>
                    <? endif; ?>
                    <div class="w-100 text-center">
                        <button type="submit" class="btn btn-primary">Войти</button>
                    </div>
                </form>
                <div class="col"></div>
            <?endif;?>
        </section>
        <section id="table-task" class="my-3 row">
            <? if (isset($data['success'])) : ?>
                <div class='alert alert-success w-100' role='alert'><?=$data['success']?></div>
            <? endif; ?>
            <table class="table table-responsive-sm">
                <thead class="thead-dark">
                    <tr>
                        <th class="text-center" scope="col">Имя пользователя</th>
                        <th class="text-center" scope="col">Email</th>
                        <th class="text-center" scope="col">Текст задачи</th>
                        <th class="text-center" scope="col">Статус</th>
                    </tr>
                </thead>
                <tbody>
                    <? foreach ($data['tasks']['fields'] as $task): ?>
                    <tr>
                        <td class="text-center"><?=$task['name']?></td>
                        <td class="text-center"><?=$task['email']?></td>
                        <td>
                            <div class="d-flex flex-column align-items-center">
                                <span><?=$task['task']?></span>
                                <? if (isset($data['user']) && $data['user']['isAdmin'] ): ?>
                                    <form class="d-none" action="\editTask" method="post">
                                        <input class="form-control" type="text" name="task" value="">
                                        <button class="btn btn-dark mt-2" type="submit" name="id" value="<?=$task['id']?>">Применить</button>
                                        <button class="btn btn-dark mt-2" type="button" data-action='editTaskStop'>Отмена</button>
                                    </form>
                                    <button class="btn btn-dark mt-2" data-action='editTask'>Редактировать</button>
                                <? endif; ?>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column align-items-center">
                                <? if ($task['status'] === 1): ?>
                                    <span class="text-success order-0">Выполнено</span>
                                <? else: ?>
                                    <span class="text-warning order-0">Новая</span>
                                    <? if (isset($data['user']) && $data['user']['isAdmin'] ): ?>
                                        <form class="order-2" action="\completeTask" method="post">
                                            <button class="btn btn-dark mt-2" type="submit" name="id" value="<?=$task['id']?>">Выполнено</button>
                                        </form>
                                    <? endif; ?>
                                <? endif; ?>
                                <? if ($task['isEdit'] === 1): ?>
                                    <span class="text-info order-1">Отредактировано</span>
                                <? endif; ?>
                            </div>
                        </td>
                    </tr>
                    <? endforeach;?>
                    <form action="\putTask" method="post">
                        <tr>
                            <td class="text-center">
                                <input type="text" class="form-control" name="name" value="<?= isset($data['formData']['name']) ? $data['formData']['name'] : ""?>">
                                <?= isset($data['errors']['name']) ? "<div class='text-danger'>{$data['errors']['name']}</div>" : ""?>
                            </td>
                            <td class="text-center">
                                <input type="email" class="form-control" name="email" value="<?= isset($data['formData']['email']) ? $data['formData']['email'] : ""?>">
                                <?= isset($data['errors']['email']) ? "<div class='text-danger'>{$data['errors']['email']}</div>" : ""?>
                            </td>
                            <td class="text-center">
                                <input type="text" class="form-control" name="task" value="<?= isset($data['formData']['task']) ? $data['formData']['task'] : ""?>">
                                <?= isset($data['errors']['task']) ? "<div class='text-danger'>{$data['errors']['task']}</div>" : ""?>
                            </td>
                            <td class="text-center"><button type="submit" class="btn btn-primary">Опубликовать</button></td>
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
<script src="assets/js/script.js?<?=time()?>"></script>
</body>
</html>