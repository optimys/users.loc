
<div class="menu"><a href="/login/logout">Logout</a>&nbsp;&nbsp;&nbsp;<a href="/profile">Profile</a></div>
<a href="/users">Users</a>
<br/>
<div class="col-md-8">
    <ul class="list-group">
        <li class="list-group-item list-group-item-success">
            <span class="badge"><?=$success?></span>
            Success:
        </li>
        <li class="list-group-item list-group-item-danger">
            <span class="bg-primary badge"><?=$failed?></span>
            Wasted:
        </li>
        <li class="list-group-item">
            <p>Users and emails already exists</p>
            <? foreach($failed_users as $wasted): ?>
            <p><?=$wasted ?><p>
            <?endforeach;?>
        </li>
    </ul>
</div>