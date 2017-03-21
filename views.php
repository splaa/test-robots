<?php
/**
 * Created by PhpStorm.
 * User: splaa
 * Date: 20.03.17
 * Time: 6:40 PM
 */







?>



<div class="table-responsive">


<table class="table ">
    <thead>
    <tr>
        <th>№</th>
        <th>Название проверки</th>
        <th>Статус</th>
        <th></th>
        <th>Текущее состояние</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td><?= $verification_name?></td>
        <td><?= $status?></td>
        <td><tr>Состояние</tr><tr>Рекомендации</tr></td>
        <td><?= $current_state?></td>
        <td><?= $recommendations?></td>
    </tr>
    </tbody>
</table>
</div>
