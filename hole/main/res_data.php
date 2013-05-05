<div id="content" class="box">   
                    <!-- Tab01 -->
      <input type="hidden" id="uid" value="">
      <input type="hidden" id="str_addr" value="<?php echo $_SERVER ['QUERY_STRING'];?>">
      <input type="hidden" id="db_n" value="<?php echo $dbname;?>">
      <input type="hidden" id="db_s" value="<?php echo $attributes['db_server'];?>">
      <input type="hidden" id="db_l" value="<?php echo $attributes['db_login'];?>">
      <input type="hidden" id="db_p" value="<?php echo $attributes['db_pwd'];?>">
      <input type="hidden" id="db_c" value="<?php echo $attributes['db_charset'];?>">
      <input type="hidden" id="db_t" value="<?php echo $attributes['db_tablename'];?>">
      <input type="hidden" id="db_i" value="<?php echo $attributes['inet_name'];?>">
      <input type="hidden" id="db_h" value="<?php echo $attributes['inet_address'];?>">

                    <!-- Tab01 -->
                    <br><br>
                    <p class="box" id="chap"><strong>Базы данных.</strong></p>     

    <div  class="tabs box" id="myTabs">
    </div>

    <div id="tab01">

        <table id="db_tab">
            <thead>
                <tr>
                    <th class="t-center">ID</th>
                    <th class="t-center">Data base</th>
                    <th class="t-center">Login</th>
                    <th class="t-center">Password</th>
                    <th class="t-center">Address</th>
                    <th class='t-center'>Charset</th>
                    <th class='t-center'>Name</th>
                    <th class='t-center'>Action</th>
                </tr>
            </thead> 
            <tbody>
                
<?php
foreach ($res_data as $value) {
     echo "<tr id='r_{$value['id']}'><td class='t-right'>{$value['id']}</td><td>{$value['db_name']}</td><td class='smaller'>{$value['login']}</td><td class='smaller'>{$value['password']}</td><td class='smaller t-center'>{$value['addr']}</td><td class='smaller t-center'>{$value['charset']}</td><td class='smaller t-center'><a href='http://{$value['inet_address']}' target='_blank'>{$value['inet_name']}</a></td><td class='t-center'><a id='v_{$value['id']}' class='ico-info' title='Смотреть'></a>&nbsp;<a id='e_{$value['id']}' class='ico-edit' title='Редактировать'></a>&nbsp;<a id='del_{$value['id']}' class='ico-delete' title='Удалить'></a></td></tr>";
}
?>
            </tbody>
        </table>

        <br>
        <p class="nom" style="text-align: center"><input value="Добавить" class="input-submit" type="button" id="add_new_base"></p>
    </div> <!-- /tab01 -->
       
<div id="tab02">
    <fieldset>     
        <div class="col50">
            <input type="hidden" value="" id="uid"/>
             <p><label for="db_name">Data base name:</label><br />
			    <input size="50" value="" class="input-text required" id="db_name" type="text"/></p>
            <p><label for="db_login">Login:</label><br />
			    <input size="50" value="" class="input-text required" id="db_login" type="text"/></p>
             <p><label for="db_password">Password:</label><br />
			    <input size="30" value="" class="input-text required" id="db_password" type="text"/></p>
            <p><label for="db_addr">Address:</label><br />
			    <input size="30" value="" class="input-text" id="db_addr" type="text"/></p>
            <p><label for="db_charset">Charset:</label><br />
                            <input size="12" value="" class="input-text digits" id="db_charset" minlength="9" maxlength="9" type="text"></p>
            <p><label for="db_s_name">Имя сайта:</label><br />
                            <input size="30" value="" class="input-text digits" id="db_s_name" type="text"></p>
            <p><label for="db_s_address">Адрес сайта<small>(без - http://)</small>:</label><br />
                            <input size="50" value="" class="input-text digits" id="db_s_address" type="text"></p>
            </div>
        </fieldset>
    
        <div class="box-01" id="back_box">
            <p class="nom" style="text-align: center">
                <input value="Сохранить" class="input-submit" type="button" id="update_db">
                &nbsp;&nbsp;
                <input value="Вернутся" class="input-submit" type="button" id="back">
            </p>
        </div> 
           
</div> <!-- /tab02 -->
</div>