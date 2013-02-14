<div id="content" class="box">   
      <input type="hidden" id="uid" value="">
      <input type="hidden" id="str_addr" value="<?php echo $_SERVER [QUERY_STRING];?>">

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
                    <th class="t-center">Название</th>
                    <th class="t-center">Data base</th>
                    <th class="t-center">Login</th>
                    <th class="t-center">Password</th>
                    <th class="t-center">Server</th>
                    <th class='t-center'>Charset</th>
                    <th class='t-center'>Action</th>
                </tr>
            </thead> 
            <tbody>
                
<?php

foreach ($res_data as $value) {
     echo "<tr id='r_$value[id]'><td class='t-right'>$value[id]</td><td>$value[inet_name]</td><td>$value[db_name]</td><td class='smaller'>$value[login]</td><td class='smaller'>$value[password]</td><td class='smaller t-center'><a class='db_link' id='a_$value[id]'>$value[addr]</a></td><td class='smaller t-center'>$value[charset]</td><td class='t-center'><a id='e_$value[id]' class='ico-edit' title='Редактировать'></a><a id='del_$value[id]' class='ico-delete' title='Удалить'></a></td></tr>";
}
?>
            </tbody>
        </table>
        <br>
        <p class="nom" style="text-align: center"><input value="Добавить" class="input-submit" type="button" id="add_new_base"></p>
    </div> <!-- /tab01 -->
       
            
<!--        <div id="add_db"> </div>-->

<div id="tab02">
    <form id="form_add_db">
        <fieldset>  
                <div class="col50">
                    <input type="hidden" value="" id="uid"/>
                    <p><label for="surname">Data base name:</label><br />
                                    <input size="50" value="" class="input-text required" id="db_name" type="text"/></p>
                    <p><label for="name">Login:</label><br />
                                    <input size="50" value="" class="input-text required" id="db_login" type="text"/></p>
                    <p><label for="phone">Password:</label><br />
                                    <input size="30" value="" class="input-text required" id="db_password" type="text"/></p>
                    <p><label for="fax">Server:</label><br />
                                    <input size="30" value="" class="input-text" id="db_addr" type="text"/></p>
                    <p><label for="postcode">Charset:</label><br />
                                    <input size="12" value="" class="input-text digits" id="db_charset" minlength="9" maxlength="9" type="text"></p>
                </div>
        </fieldset>

        <div class="box-01" id="back_box">
            <p class="nom" style="text-align: center"><input value="Сохранить" class="input-submit" type="button" id="update_db">&nbsp;&nbsp;<input value="Вернутся" class="input-submit" type="button" id="back"></p>
        </div> 
   </form>    
</div> <!-- /tab02 -->
</div>