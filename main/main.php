<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div id="tray" class="box">
        <p class="f-left box">		

                <strong>&nbsp;<a href="index.php?act=main">Кабинет </a></strong>
    <!-- Здесь сделать вывод сообщений в зависимости от роли -->
        </p>
                <form action='index.php?act=logout' method='post' name="logout_form">
                    <p class="f-right">
                        <strong><?php echo "$user[name]&nbsp$user[surname]";?></strong> &nbsp;&nbsp;&nbsp; 
                        <strong>
                            <a href="javascript:document.logout_form.submit();" id="logout">Выход</a>
                        </strong>
                    </p>
                </form>
</div>